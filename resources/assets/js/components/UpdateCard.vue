<template>
    <div>
        <button class="btn btn-success" @click="update">Update Card Details</button>

    </div>
</template>
<script>
    import Axios from 'axios'
    import Swal from 'sweetalert'
    export default {
        props: ['email'],
        mounted() {
            this.handler = StripeCheckout.configure({
                key: 'pk_test_SZyPd0YXuAfFacr5u7X6wbLp',
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                locale: 'auto',
                allowRememberMe:false,
                token(token) {
                    Swal({text:'Please wait while we update card Details...',buttons:false})
                    Axios.post('/card/update', {
                        StripeToken: token.id,
                    }).then(resp=>{
                        Swal({text:'Successfully Updated',icon:'success'}).then(()=>{
                            window.location=''
                        });
                    })
                    console.log(token)
                }
            })
        },
        data() {
            return {

                handler: null,
            }
        },
        methods: {
            update() {

                this.handler.open({
                    name: 'Schandboy',
                    email: this.email,
                    description: '2 widgets',
                    panelLabel:'Update Card Details'
                })
            }
        }
    }
</script>