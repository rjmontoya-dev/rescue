<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {computed, onMounted,ref} from 'vue';
import VueApexCharts from 'vue3-apexcharts';
import { ref as dbRef, onChildChanged,onChildAdded } from 'firebase/database';
import db from '@/firebase';

const weather_data =  ref([]);
const weather_dataReady = ref(false);

const success = async (position) => {
  const latitude = position.coords.latitude;
  const longitude = position.coords.longitude;
  const api = '05523e17e80c4d7b3ec006e16ad639f4';
  const weatherApi = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${api}`;

  try {
    const response = await fetch(weatherApi);
    const data = await response.json();
    return data; // Return the data to resolve the Promise
  } catch (error) {
    console.error('Error fetching weather data:', error);
    throw error; // Throw the error to reject the Promise
  }
};

const error = () => {
  console.log("Can't fetch your position");
};

const convertToCelsius = (val) => {
  return val - 273.15;
};

const getCurrentPositionAsync = () => {
  return new Promise((resolve, reject) => {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        success(position)
          .then((data) => resolve(data))
          .catch((error) => reject(error));
      },
      () => {
        error();
        reject("Can't fetch your position");
      }
    );
  });
};





onMounted(async () => {

  try {
    const positionData = await getCurrentPositionAsync();
    weather_data.value = [
            {name:'locations',data: positionData.name},
            {name:'description',data: positionData.weather[0].description},
            {name:'icon',data:positionData.weather[0].icon},
            {name:'temp',data:convertToCelsius(positionData.main.temp).toFixed(2)},
            {name:'temp_min',data:convertToCelsius(positionData.main.temp_min).toFixed(2)},
            {name:'temp_max',data:convertToCelsius(positionData.main.temp_max).toFixed(2)},
            {name:'feels_like',data:convertToCelsius(positionData.main.feels_like).toFixed(2)},
            {name:'humidity',data:positionData.main.humidity},
            {name:'visibility',data:positionData.visibility},
            {name:'wind_speed',data:positionData.wind.speed},
            {name:'gust',data:positionData.wind.gust},
            {name:'deg',data:positionData.wind.deg},
            {name:'pressure',data:positionData.main.pressure},
            {name:'sea_level',data:positionData.main.sea_level},
        ];
    weather_dataReady.value = true;

  } catch (error) {
    console.error(error);
  }
});


</script>
<script>
    export default {
        data(){
            return {
                chartOptions: {

                    chart: {
                        id: 'vuechart-example',
                    },
                    title: {
                        text: 'Water Level Chart Monitoring',
                        align: 'left'
                    },
                    dataLabels: {
                        enabled: true,
                        },
                    stroke: {
                        curve: 'smooth'
                        },
                    colors: ['#38bdf8'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            inverseColors: false,
                            opacityFrom: 0.5,
                            opacityTo: 0,
                            stops: [0, 90, 100],
                        },
                    },
                    xaxis:  {
                        title: {
                            text: 'Time',
                        },
                        type:'date',
                        categories: ref([]),
                    } ,
                    yaxis: {
                        title: {
                            text: 'Water Level',
                        },
                        min: 10,
                        max: 30,
                    },
                },
                series : [
                    {
                        name: 'Level',
                        data: ref([])
                    }
                ]
            }
        },
        methods:{
            getWaterLevel ()  {
                const stationDataRef = dbRef(db, 'water-level/readings/');
                const snapshotValue = ref([]);
                const reading = ref([]);
                const xTime = ref([]);
                onChildAdded(stationDataRef, (snapshot) => {
                    snapshotValue.value = snapshot.val();
                    reading.value.push(snapshotValue.value['val']);
                    xTime.value.push(new Date().toLocaleTimeString());
                    this.updateChart(reading.value.slice(),xTime.value);
                    if(reading.value.length >= 10){
                        reading.value.shift();
                        xTime.value.shift();
                    }
                });

            },
            updateChart(ySeries = [],xSeries = []){
                this.series[0].data = [...ySeries];
                this.chartOptions.xaxis.categories = xSeries ;

            },
        },
        mounted(){
            this.updateChart();
            this.getWaterLevel();
        }
    }
</script>

<template>
     <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white   "  >
                <div class="grid grid-cols-5">
                    <div class="col-span-3">
                        <div class="  text-2xl font-medium text-gray-900">
                            {{ weather_dataReady ? weather_data[0].data : '...' }} Philippines
                        </div>
                        <div class="mt-8">
                            <span class=" font-thin text-gray-500 ">Feels Like </span>
                        </div>
                        <div>
                            <span class="text-7xl font-medium text-gray-900">{{weather_dataReady ? weather_data[3].data : '...' }} &deg;</span>
                        </div>
                        <div class="uppercase text-gray-500">
                            {{weather_dataReady ? weather_data[1].data : '...' }}
                        </div>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <img class="w-32 h-32" :src="`images/weather-icons/${weather_dataReady ? weather_data[2].data : '...'}.png`" alt="Weather Icon">
                    </div>
                </div>
                <div class="grid grid-rows-7 grid-flow-col gap-2  ">
                    <div class="mt-6">
                        <div class="font-medium text-sm">Humidity</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[7].data : '...' }}%</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Visibility</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[8].data : '...' }}km</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Wind Speed</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[9].data : '...' }}km/h</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Gust</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[10].data : '...' }}m/s</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Deg</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[11].data : '...' }} &deg </div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Pressure</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[12].data : '...' }}mb</div>
                    </div>
                        <div class="mt-6">
                        <div class="font-medium text-sm">Sea Level</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[13].data : '...' }}hPa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-xl  ">
            <div class="bg-white ">
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                       </div>
                    <div class="flex justify-between">
                            <div class="flex">
                                <div class=" "><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                <p class="font-bold ">RealTime Data of Water Level</p>
                            </div>
                        <p class="text-right text-lg  font-bold">{{ this.series[0].data[this.series[0].data.length -1] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
            <div class="bg-white  ">
               <div id="chart" class="px-8 py-10">
                    <VueApexCharts type="area"   height="350" :options="chartOptions" :series="series"></VueApexCharts>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>

</style>
