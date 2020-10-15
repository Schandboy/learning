<template>
    <div>
        <button class="btn btn-success" @click="subscribe('monthly')">Pay Monthly</button>
        <button class="btn btn-info" @click="subscribe('yearly')">Pay Yearly</button>
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
                token(token) {
                    Swal({text:'Please wait while we subscribe you to a plan...',buttons:false})
                    Axios.post('/subscribe', {
                        StripeToken: token.id,
                        plan: window.StripePlan
                    }).then(resp=>{
                        Swal({text:'Successfully Subscribed',icon:'success'}).then(()=>{
                            window.location=''
                            });
                    })
                    console.log(token)
                }
            })
        },
        data() {
            return {
                plan: '',
                handler: null,
                amount: 0
            }
        },
        methods: {
            subscribe(plans) {
                if (plans == 'monthly') {
                    window.StripePlan = "monthly";
                    this.amount = 99.99;
                } else {
                    window.StripePlan = "yearly";
                    this.amount = 9999;
                }
                this.handler.open({
                    name: 'Schandboy',
                    email: this.email,
                    description: '2 widgets',
                    amount: this.amount
                })
            }
        }
    }
</script>