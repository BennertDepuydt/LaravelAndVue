import Vue from "vue";

declare module 'vue/types/vue' {
    interface Vue {
        $auth: VueAuth
    }

    interface VueConstructor {
        $auth: VueAuth;
    }
}

declare module 'vue/types/options' {
    interface ComponentOptions<V extends Vue> {
        auth?: VueAuth;
    }
}

interface VueAuth {
    login: (data: any) => Promise<any>
    logout: (data: any) => Promise<any>
    refresh: () => Promise<any>
    fetch: () => Promise<any>
    user: () => any | undefined
    remember: () => string | undefined
    unremember: () => void
    ready: () => boolean
}
