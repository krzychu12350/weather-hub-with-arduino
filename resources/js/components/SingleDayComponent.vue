<template>
    <div class="wrapper me-4">
        <div class="bg-image">
            <span class="single-day-details">{{ dayOfWeek }} {{ dayOfMonth }}</span><br>
            <img v-bind:src="'https://openweathermap.org/img/wn/' + iconOfDay + '@2x.png'" /><br>
            <span class="single-day-details">{{ maxDailyTemp }}° C</span>
            <span class="single-day-details">{{ minDailyTemp }} ° C</span><br>
            <span class="single-day-details">{{ descriptionOfDay }}</span>
        </div>
    </div>

</template>

<script>
export default {
    name: "SingleDayComponent",
    props: {
        dayOfWeek: String,
        dayOfMonth: Number,
        maxDailyTemp: Number,
        minDailyTemp: Number,
        iconOfDay: String,
        descriptionOfDay: String
    },
}
</script>

<style lang="scss">
@use "sass:math";
@mixin down_arrow($arrow_width: 20%, $arrow_height: 20%) {
    $height: 100% - $arrow_height;
    $left_arrow_pos: 50% - math.div($arrow_width, 2);
    $right_arrow_pos: 50% + math.div($arrow_width, 2);
    clip-path: polygon(0 0, 100% 0, 100% $height, $right_arrow_pos $height, 50% 100%, $left_arrow_pos $height, 0 $height);
    -webkit-clip-path: polygon(0 0, 100% 0, 100% $height, $right_arrow_pos $height, 50% 100%, $left_arrow_pos $height, 0 $height);
    margin-bottom: - math.div($arrow_height, 2);
}
.bg-image {
    //background-image: url(https://unsplash.it/1500/750?image=1041);
    //background-size: cover;
    height: 200px;
    @include down_arrow(6%, 6%);
    //border: 2px solid red;
}

.wrapper {
    width: 150px;
//margin: 50px auto;
    cursor: pointer;
}
.bg-image:hover {
    background-color: #FFFFFF;
    opacity: 0.6;
}
.single-day-details {
    color: #FFFFFF;
    font-size: 1rem;
}
</style>
