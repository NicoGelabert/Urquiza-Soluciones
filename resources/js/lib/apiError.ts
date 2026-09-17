export function getApiErrorMessage(error: any, fallback: string): string {
    return (
        error?.response?.data?.message
        ?? Object.values(error?.response?.data?.errors ?? {})?.flat()?.[0]
        ?? fallback
    );
}
