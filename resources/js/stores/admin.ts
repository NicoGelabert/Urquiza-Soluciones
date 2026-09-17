import { defineStore } from 'pinia';
import axios from 'axios';

interface PaginationState {
    loading: boolean;
    data: any[];
    total: number;
    page: number;
    limit: number;
    from: number | null;
    to: number | null;
    links: any[];
}

function defaultPagination(): PaginationState {
    return {
        loading: false,
        data: [],
        total: 0,
        page: 1,
        limit: 10,
        from: null,
        to: null,
        links: [],
    };
}

function applyPagination(state: PaginationState, response: any) {
    const { data, meta } = response.data;
    state.data = data;
    state.total = meta.total;
    state.page = meta.current_page;
    state.limit = meta.per_page;
    state.from = meta.from;
    state.to = meta.to;
    state.links = meta.links;
}

export const useFaqStore = defineStore('faqs', {
    state: (): PaginationState => defaultPagination(),

    actions: {
        async fetchList(params: Record<string, any> = {}) {
            this.loading = true;
            try {
                const response = await axios.get('/api/faqs', { params });
                applyPagination(this, response);
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id: number) {
            return axios.get(`/api/faqs/${id}`);
        },

        async create(data: any) {
            return axios.post('/api/faqs', data);
        },

        async update(data: any) {
            return axios.put(`/api/faqs/${data.id}`, data);
        },

        async remove(id: number) {
            return axios.delete(`/api/faqs/${id}`);
        },
    },
});

export const useServicioStore = defineStore('servicios', {
    state: (): PaginationState => defaultPagination(),

    actions: {
        async fetchList(params: Record<string, any> = {}) {
            this.loading = true;
            try {
                const response = await axios.get('/api/servicios', { params });
                applyPagination(this, response);
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id: number) {
            return axios.get(`/api/servicios/${id}`);
        },

        toFormData(data: any): FormData {
            const form = new FormData();
            const skip = ['items', 'imagen_cabecera', 'imagen_cabecera_path'];

            for (const key of Object.keys(data)) {
                if (skip.includes(key) || data[key] === null || data[key] === undefined) continue;
                if (typeof data[key] === 'object' && !(data[key] instanceof File)) {
                    form.append(key, JSON.stringify(data[key]));
                } else if (typeof data[key] === 'boolean') {
                    form.append(key, data[key] ? '1' : '0');
                } else {
                    form.append(key, data[key]);
                }
            }

            if (data.items) {
                form.append('items', JSON.stringify(data.items));
            }

            if (data.imagen_cabecera instanceof File) {
                form.append('imagen_cabecera', data.imagen_cabecera);
            }

            return form;
        },

        async create(data: any) {
            return axios.post('/api/servicios', this.toFormData(data));
        },

        async update(data: any) {
            const form = this.toFormData(data);
            form.append('_method', 'PUT');
            return axios.post(`/api/servicios/${data.id}`, form);
        },

        async remove(id: number) {
            return axios.delete(`/api/servicios/${id}`);
        },
    },
});

export const useContenidoStore = defineStore('contenido', {
    state: (): PaginationState => defaultPagination(),

    actions: {
        async fetchList(params: Record<string, any> = {}) {
            this.loading = true;
            try {
                const response = await axios.get('/api/contenido', { params });
                applyPagination(this, response);
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id: number) {
            return axios.get(`/api/contenido/${id}`);
        },

        async update(data: any) {
            return axios.put(`/api/contenido/${data.id}`, data);
        },
    },
});

export const useLegalStore = defineStore('legal', {
    state: () => ({ loading: false, data: [] as any[] }),

    actions: {
        async fetchList() {
            this.loading = true;
            try {
                const response = await axios.get('/api/legal');
                this.data = response.data.data;
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id: number) {
            return axios.get(`/api/legal/${id}`);
        },

        async update(data: any) {
            return axios.put(`/api/legal/${data.id}`, data);
        },
    },
});

export const useSolicitudStore = defineStore('solicitudes', {
    state: (): PaginationState => defaultPagination(),

    actions: {
        async fetchList(params: Record<string, any> = {}) {
            this.loading = true;
            try {
                const response = await axios.get('/api/solicitudes', { params });
                applyPagination(this, response);
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id: number) {
            return axios.get(`/api/solicitudes/${id}`);
        },

        async update(data: any) {
            return axios.put(`/api/solicitudes/${data.id}`, data);
        },
    },
});

export const useConfiguracionStore = defineStore('configuracion', {
    state: () => ({
        loading: false,
        data: {
            telefono: '',
            whatsapp: '',
            instagram: '',
            email: '',
            telefono_urgencias: '',
        },
    }),

    actions: {
        async fetch() {
            this.loading = true;
            try {
                const response = await axios.get('/api/configuracion');
                this.data = response.data;
            } finally {
                this.loading = false;
            }
        },

        async update(data: any) {
            return axios.put('/api/configuracion', data);
        },
    },
});
