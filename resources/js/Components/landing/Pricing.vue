<template>
    <div class="mt-10">
        <h2 class="text-h3 text-custom text-center font-weight-bold">
            Simple Pricing
        </h2>
        <p class="mt-2 text-h6 font-weight-regular w-50 mx-auto text-center">
            Save months of development time. Choose the plan that fits your
            needs.
        </p>

        <v-container class="mt-3">
            <v-row justify="center">
                <v-col cols="12" md="4" v-for="n in 3">
                    <div class="border pa-3 rounded-lg">
                        <h6 class="text-h5 font-weight-bold ml-4">Starter</h6>
                        <h6 class="text-h5 font-weight-bold ml-4 mb-2">
                            $99
                            <span class="text-medium-emphasis text-h6">
                                once
                            </span>
                        </h6>

                        <v-list-item
                            v-for="n in 3"
                            title="Complete Source Code"
                        >
                            <template #prepend>
                                <v-icon icon="mdi-check" color="success" />
                            </template>
                        </v-list-item>

                        <div class="mt-6 w-75 mx-auto">
                            <v-btn
                                text="Get Started"
                                block
                                variant="outlined"
                                color=""
                            />
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
