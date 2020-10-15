<template>
    <div>
        <div :data-vimeo-id="lesson.video_id" data-video-width="800" v-if="lesson" id="handwatch"></div>
    </div>
</template>
<script>
    import Swal from 'sweetalert'
    import Player from '@vimeo/player'
import Axios from 'axios'
    export default {
        props: ['default_lesson','next_lesson'],
        data() {
            return {
                lesson: JSON.parse(this.default_lesson)
            }
        },
        methods:{
            videoEndedAlert(){
                if (this.next_lesson) {
                    Swal('You Completed this Lesson').then(()=> {
                        window.location = this.next_lesson
                        }
                    )
                }
                else{
                    Swal('You Completed this Series')
                }
            },
            completeLesson(){
                Axios.post(`/series/complete-lesson/${this.lesson.id}`,{})
                .then(resp=>{
                    this.videoEndedAlert();
                })

            }
        },

        mounted() {


            const player = new Player('handwatch');
            player.on('ended',()=>{
                this.completeLesson()
            })
        }
    }
</script>