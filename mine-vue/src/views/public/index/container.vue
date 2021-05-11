<template>
  <keep-alive>
    <router-view v-if="$route.meta.cache" />
  </keep-alive>
</template>
