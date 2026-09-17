let scriptLoaded = false;

export function loadRecaptchaScript(siteKey: string): Promise<void> {
    if (scriptLoaded && window.grecaptcha) {
        return Promise.resolve();
    }

    return new Promise((resolve, reject) => {
        if (document.getElementById('recaptcha-script')) {
            window.grecaptcha?.ready(() => {
                scriptLoaded = true;
                resolve();
            });
            return;
        }

        const script = document.createElement('script');
        script.id = 'recaptcha-script';
        script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey}`;
        script.async = true;
        script.onload = () => {
            window.grecaptcha?.ready(() => {
                scriptLoaded = true;
                resolve();
            });
        };
        script.onerror = () => reject(new Error('Failed to load reCAPTCHA'));
        document.head.appendChild(script);
    });
}

export async function executeRecaptcha(siteKey: string, action: string): Promise<string> {
    await loadRecaptchaScript(siteKey);
    return window.grecaptcha!.execute(siteKey, { action });
}
