<template>
    <form @submit.prevent="submitForm">
        <InputField
            name="name"
            label="Nombre"
            placeholder="Nombre del contacto"
            :errors="errors"
            @update:field="form.name = $event"/>

        <InputField
            name="email"
            label="Email"
            :errors="errors"
            placeholder="Email del contacto"
            @update:field="form.email = $event"/>

        <InputField
            name="company"
            label="Compañia"
            :errors="errors"
            placeholder="Compañia del contacto"
            @update:field="form.company = $event"/>

        <InputField
            name="birthday"
            label="Fecha de Cumpleaños"
            :errors="errors"
            placeholder="MM/DD/YYYY"
            @update:field="form.birthday = $event"/>

        <div class="flex justify-end">
            <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancelar</button>
            <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Agregar Nuevo Contacto</button>
        </div>
    </form>
</template>

<script>
import InputField from '../components/InputField';

export default {
    name: "ContactsCreate",
    components: {
        InputField
    },

    data: function () {
        return {
            form: {
                'name': '',
                'email': '',
                'company': '',
                'birthday': '',
            },
            errors: null,
        }
    },
    methods: {
        submitForm: function () {
            axios.post('/api/contacts', this.form)
                .then(response => {

                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });
        }
    }
}
</script>

<style scoped>

</style>
