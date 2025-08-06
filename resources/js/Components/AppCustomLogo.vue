<template>
    <base-link :href="route('welcome')">
        <div class="d-flex align-center ga-2">
            <v-avatar class="bg-custom" tile rounded>
                <span class="font-weight-black text-h6">LV</span>
            </v-avatar>
            <p class="text-custom font-weight-bold text-h6">LaraVue Kit</p>
        </div>
    </base-link>
</template>

<style scoped>
.bg-custom {
    background-image: linear-gradient(to right, #a855f7, #ec4899);
    color: white;
}

.text-custom {
    background-image: linear-gradient(to right, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}
</style>
