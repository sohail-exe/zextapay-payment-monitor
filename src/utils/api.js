const getHeaders = () => ({
    'X-WP-Nonce': window.zextapayData?.nonce,
    'Content-Type': 'application/json',
});

const apiUrl = () => window.zextapayData?.apiUrl;

export const fetchStats = () =>
    fetch(`${apiUrl()}/stats`, { headers: getHeaders() }).then((r) => r.json());

export const fetchLogs = () =>
    fetch(`${apiUrl()}/logs`, { headers: getHeaders() }).then((r) => r.json());

export const fetchSettings = () =>
    fetch(`${apiUrl()}/settings`, { headers: getHeaders() }).then((r) => r.json());

export const saveSettings = (data) =>
    fetch(`${apiUrl()}/settings`, {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(data),
    }).then((r) => r.json());

export const formatCurrency = (amount) => {
    const currency = window.zextapayData?.currency_code || 'USD';
    return new Intl.NumberFormat(undefined, {
        style: 'currency',
        currency,
        currencyDisplay: 'symbol',
    }).format(amount || 0);
};