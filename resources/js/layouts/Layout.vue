<script setup>
import { useGeneralStore } from "@/store/general";

const generalStore = useGeneralStore();
</script>
<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/book"
                            >Knihy</a
                        >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/author"
                            >Autori</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div
            v-if="generalStore.flashMessage"
            :class="`alert alert-${generalStore.flashMessage.status}`"
            role="alert"
        >
            {{ generalStore.flashMessage.message }}
        </div>

        <slot />
    </div>
</template>
