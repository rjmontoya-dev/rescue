<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Common/FloodTab/Cards/Card.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
const cardData = [
    {title: "Preparing For a Flood", img:"/images/preparingflood.jpg",alt: "preparingflood",
    body: "Learn how to prepare for a flood, including how to create a plan, supplies you'll need, and getting your home ready",
    url: "preparing-flood",},
    {title: "Floodwater Safety", img: "/images/floodwater.jpg",alt: "floodWater-safety",
    body: "Floodwater and standing water can be dangerous. Protect yourself and your loved ones from risks brought on by floods.",
    url: "flood-water-safety",},
    {title: "Returning Home", img: "/images/returning-home.jpg",alt: "returning-home",body: "Returning home after a flood? Be aware that your home may be contaminated with mold or sewage. Take steps to keep yourself and your loved ones safe.",
    url: "returning-home",},
]
const resources = [
    {title:"Drinking Water Advisory Communication Toolkit",url: "https://www.epa.gov/flooded-homes",},
    {title:"Emergency Water Supply Planning Guide [PDF  6.21 MB]",url:"https://www.cdc.gov/healthywater/emergency/pdf/emergency-water-supply-planning-guide-2019-508.pdf"}
]
</script>
<template>
    <AppLayout title="Flood">
        <div class=" rounded-lg p-4 mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <section class="p-10">
                    <div class="md:grid md:grid-cols-3 md:gap-6  ">
                        <SectionTitle>
                            <template #title>
                            FLOOD
                            </template>
                            <template #description>
                            <p>Floods, big or small, can have devastating effects on your home
                            and your family. You can take steps to reduce the harm caused
                            by flooding. Learn how to prepare for a flood, stay safe during
                            a flood, and protect your health when you return home after a flood.
                        </p>
                            </template>
                        </SectionTitle>
                        <div class="col-span-2">
                            <div class=" bg-white shadow mt-4 rounded-lg md:mt-0 md:col-span-2 p-4 mb-2">
                                <img clas="rounded-t-lg w-full" src="/images/floodBanner.jpg">
                            </div>
                        </div>
                    </div>
                </section>
                <section class="p-10">
                    <div class=" md:grid md:grid-cols-3 md:gap-4">
                        <Card v-for="item in cardData"
                        :title="item.title"
                        :img="item.img"
                        :alt="item.alt"
                        :body="item.body"
                        :url="item.url"
                    >
                    </Card>
                    </div>
                </section>
                <section class="p-10">
                    <div class="bg-white border-gray-800 rounded-lg ">
                        <h5 class="bg-gray-800 rounded-t-md p-2  text-xl  tracking-tight  text-white">Resources</h5>
                        <div class="body p-4">
                            <ul class="list-disc pl-5" v-for="item in resources">
                                <li class="underline"><a :href="item.url">{{ item.title }}</a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
