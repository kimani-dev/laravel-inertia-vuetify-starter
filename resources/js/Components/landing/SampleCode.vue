<template>
    <div class="mt-10">
        <h2 class="text-h3 text-custom text-center font-weight-bold">
            Clean, Modern Code
        </h2>
        <p class="mt-2 text-h6 font-weight-regular w-50 mx-auto text-center">
            Built with best practices and modern patterns for maintainability
            and scalability.
        </p>

        <v-container class="mt-5">
            <v-row>
                <v-col v-for="n in 2">
                    <v-card subtitle="kimani.js" variant="outlined">
                        <template #append>
                            <div class="d-flex align-center ga-1">
                                <v-icon
                                    icon="mdi-circle"
                                    size="x-small"
                                    color="error"
                                />
                                <v-icon
                                    icon="mdi-circle"
                                    size="x-small"
                                    color="warning"
                                />
                                <v-icon
                                    icon="mdi-circle"
                                    size="x-small"
                                    color="success"
                                />
                            </div>
                        </template>
                        <template #text>
                            <code>
                                // Send notification with one line
                                <br />
                                this.$notify.success('User created
                                successfully!'); <br />
                                <br />
                                // Queue email notification <br />
                                this.$notify.email(user, 'welcome-email');
                                <br />
                                <br />
                                // Flash message with redirect
                                <br />
                                this.$flash.success('Settings
                                saved!').redirect('/dashboard');
                            </code>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
