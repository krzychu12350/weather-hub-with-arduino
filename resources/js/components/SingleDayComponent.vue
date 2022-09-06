<template>
    <div class="wrapper me-4">
        <div class="bg-image">
            <span
                class="single-day-details"
            >
                {{ dayOfWeek }} {{ dayOfMonth }}
            </span><br>
            <img
                :src="'https://openweathermap.org/img/wn/' +
                iconOfDay + '@2x.png'"
            /><br>
            <span
                class="single-day-details me-2"
            >
                <font-awesome-icon
                    class="temp-icon"
                    icon="fa-solid fa-temperature-full"
                    color="white"
                    size="sm"/>
                {{ maxDailyTemp.toFixed(0) }}°
            </span>
            <span class="single-day-details">
                <font-awesome-icon
                 class="temp-icon"
                 icon="fa-solid fa-temperature-full"
                 color="white"
                 size="sm"/>
                {{ minDailyTemp.toFixed(0) }}°
            </span><br>
            <span
                class="single-day-details"
            >
                {{ descriptionOfDay }}
            </span>
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
    height: 200px;
    @include down_arrow(6%, 6%);
    padding: 0.25rem;
}

.wrapper {
    width: 150px;
    cursor: pointer;
}

.bg-image:hover {
    background-color: rgba(255, 255, 255, .3);

}

.single-day-details {
    color: #FFFFFF;
    font-size: 1rem;
}
</style>
