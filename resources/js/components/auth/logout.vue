<template>

</template>

<script type="text/javascript">
 export default{
     created(){
         localStorage.removeItem('token')
         localStorage.removeItem('user')

        Toast.fire({
            icon: 'success',
            title: 'Successfully Logged Out'
        })


        this.$router.push({name:'/'})

     }
 }
</script>

<style type ="text/css">

</style>
