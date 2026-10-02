import { resolveIconPath } from '@/lib/serviceIcons';

/** Iconos de confianza y bloques de landing (slug => path SVG fill). */
export const landingIconPaths: Record<string, string> = {
    shield:
        'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    star: 'M12 2l2.39 7.26H22l-6.19 4.5 2.36 7.26L12 16.77l-6.17 4.25 2.36-7.26L2 9.26h7.61L12 2z',
    'map-pin':
        'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z',
    clock:
        'M12 2a10 10 0 100 20 10 10 0 000-20zm1 11H7v-2h4V7h2v6z',
    chat:
        'M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z',
};

export function resolveLandingIconPath(icon: string): string {
    return landingIconPaths[icon] ?? resolveIconPath(icon);
}
