<template>
    <div id="app">
        <nav v-if="isAuthenticated" class="navbar navbar-expand navbar-dark bg-dark">
            <div class="navbar-nav me-auto">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link"> Usuarios</router-link>
                </li>
            </div>

            <div class="navbar-nav ms-auto">
                <li class="nav-item">
                    <logout />
                </li>
            </div>
        </nav>
        <br>

        <div class="container">
            <router-view />
        </div>
    </div>
</template>

<script>
import { isAuthenticated } from "../events/eventLogin";
import logout from "./auth/logout.vue";

export default {
    name: "App",
    components: {
        logout,
    },
    setup() {
        return { isAuthenticated };
    },
};
</script>
