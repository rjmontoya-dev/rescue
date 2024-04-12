export function convertTo (){

    const dateConverter = (date)=>{
          const inputDate = new Date(date);
        const options = {
        weekday: 'long',
        month: 'short',
        day: '2-digit',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
        };

        const formattedDate = new Intl.DateTimeFormat('en-US', options).format(inputDate);
       return formattedDate;
    }
    return {
        dateConverter,
    }
}
