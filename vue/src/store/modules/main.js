// src/store/modules/user/index.ts

import { defineStore } from 'pinia';

export const useMainStore = defineStore('main', {
  // id: 'user', // id必填，且需要唯一。两种写法
  state: () => {
    return {
      isLoading: false,
    };
  }
});
