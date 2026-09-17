import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import { PageProps as AppPageProps } from './';

interface AnalyticsConfig {
    googleId: string | null;
    clarityId: string | null;
}

declare global {
    interface Window {
        axios: AxiosInstance;
        __ANALYTICS__?: AnalyticsConfig;
        gtag?: (...args: unknown[]) => void;
        clarity?: (...args: unknown[]) => void;
        grecaptcha?: {
            ready: (callback: () => void) => void;
            execute: (siteKey: string, options: { action: string }) => Promise<string>;
        };
    }

    /* eslint-disable no-var */
    var route: typeof ziggyRoute;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
