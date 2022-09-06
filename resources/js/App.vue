<template>
    <router-view/>
    <UserAccountDeletingConfirmationModalComponent class="text-center" />
    <LogoutConfirmationModalComponent class="text-center" />
</template>

<script>
import LogoutConfirmationModalComponent from "./components/LogoutConfirmationModalComponent.vue";
import UserAccountDeletingConfirmationModalComponent
    from "./components/UserAccountDeletingConfirmationModalComponent.vue";
import SidebarComponent from "./components/SidebarComponent.vue";

export default {
    name: "App",
    components: {
        SidebarComponent,
        LogoutConfirmationModalComponent,
        UserAccountDeletingConfirmationModalComponent,
    },
}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #2698f8f5;
}
.primary-container {
    background-size: cover;
    background-repeat: no-repeat;
}
</style>
