<template>
    <div>
        <h1>Desde componente ContactsShow</h1>
    </div>
</template>

<script>
export default {
    name: "ContactsShow",
    mounted() {
        window.axios.get('/api/contacts/1')
            .then(response => {
                console.log(response)
            })
            .catch(error => {

            })
    }
}
</script>

<style scoped>

</style>
