export function isEnglish(locale: string): boolean {
    return locale === 'en';
}

export function urlHome(locale: string): string {
    return isEnglish(locale) ? '/en' : '/';
}

export function urlServices(locale: string): string {
    return isEnglish(locale) ? '/en/services' : '/servicios';
}

export function urlService(locale: string, slug: string): string {
    return isEnglish(locale) ? `/en/services/${slug}` : `/servicios/${slug}`;
}

export function urlContact(locale: string): string {
    return isEnglish(locale) ? '/en/contact' : '/contacto';
}

export function urlQuote(locale: string): string {
    return isEnglish(locale) ? '/en/quote' : '/presupuesto';
}

export function urlLegal(locale: string, slug: string): string {
    return isEnglish(locale) ? `/en/legal/${slug}` : `/legal/${slug}`;
}
