<template>

    <router-view/>

    <ConfirmationModalComponent></ConfirmationModalComponent>
</template>

<script>
import ConfirmationModalComponent from "./components/ConfirmationModalComponent.vue";
import SidebarComponent from "./components/SidebarComponent.vue";
export default {
    name: "App",
    components: {
        SidebarComponent,
        ConfirmationModalComponent
    },
}
</script>

<style lang="scss">
/* Google Font Import - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
//@import url('https://fonts.googleapis.com/css2?family=BioRhyme:wght@200;400&family=Cormorant:ital,wght@1,500&family=Piazzolla:opsz@8..30&display=swap');
//@import url('https://fonts.googleapis.com/css2?family=BioRhyme:wght@200;400&family=Cormorant:ital,wght@1,500&family=Piazzolla:opsz@8..30&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    //font-family: 'BioRhyme', serif;

    //font-family: 'Cormorant', serif;

    //font-family: 'Piazzolla', serif;
}

/*
@import url('https://fonts.googleapis.com/css2?family=BioRhyme:wght@200;400&family=Cormorant:ital,wght@1,500&family=Piazzolla:opsz@8..30&display=swap');

*, *::before, *::after {
    margin: 0;
    padding: 0;


    font-family: 'Cormorant', serif;
}
*/

body {
    /*
    background-image: url('assets/images/cloudy-sky-day.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    */
}
/*
.container {


    max-width: 100%;
    max-height: 100%;
    min-height: 100vh;
}
*/


.primary-container {
    /*
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
    0 10px 10px rgba(0, 0, 0, 0.22);
    overflow: hidden;
    height: 800px;
    background-color: rgba(238, 238, 238, 0.07)
     */

    /*
    background-image: url('./assets/images/cloudy-sky-day.jpg');
    background-repeat: no-repeat;
    background-size: cover;

     */
}



</style>
