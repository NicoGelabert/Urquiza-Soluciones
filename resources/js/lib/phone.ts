/** Quita espacios y separadores habituales; conserva + y dígitos para tel: / wa.me. */
export function normalizePhoneForLink(phone?: string | null): string | undefined {
    if (!phone?.trim()) {
        return undefined;
    }

    const cleaned = phone.replace(/[\s().-]/g, '');

    return cleaned || undefined;
}

export function telHref(phone?: string | null): string | undefined {
    const cleaned = normalizePhoneForLink(phone);

    return cleaned ? `tel:${cleaned}` : undefined;
}

export function whatsappHref(phone?: string | null): string | undefined {
    if (!phone?.trim()) {
        return undefined;
    }

    const digits = phone.replace(/\D/g, '');

    return digits ? `https://wa.me/${digits}` : undefined;
}
