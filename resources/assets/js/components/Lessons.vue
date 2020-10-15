<template>
    <div class="container" style="color:black;font-weight: bold">
        <h1 class="text-center">
            <button class="btn btn-primary" @click="createNewLesson()">
                Create New Lesson
            </button>
        </h1>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between" v-for="(lesson,key) in lessons">
               <p>{{lesson.title}}</p>

                <p>
                    <button class="btn btn-primary btn-sm" @click="updateLesson(lesson)">Edit</button>
                    <button class="btn btn-danger btn-sm" v-on:click="deleteLesson(lesson.id,key)">Delete</button>
                </p>
            </li>
        </ul>
        <create-lessons></create-lessons>
    </div>
</template>
<script>
    import Axios from 'axios'
    export default {
        props:['default_lessons','series_id'],
        components:{
            'create-lessons':require('./children/createLessons')
        },
        mounted() {
            this.$on('created_lesson',(lesson)=>{
                window.noty({
                    message:'Lesson Created Successfully',
                    type:'danger'
                })
                this.lessons.push(lesson);
                }
            );
            this.$on('lesson_updated',(lesson)=>{
                let lessonIndex=this.lessons.findIndex(l=>{
                    return l.id==lesson.id;
                });
                this.lessons.splice(lessonIndex,1,lesson);
            });
        },
        data()
            {
                return{
                    lessons:JSON.parse(this.default_lessons)
                }

        },
        computed:{

        },
        methods:{
            createNewLesson(){
                this.$emit('create_new_lesson',this.series_id)
            },
            deleteLesson(id,key) {
                if (confirm('Are you sure want to Delete')) {
                    Axios.delete(`/admin/${this.series_id}/lessons/${id}`)
                    .then(resp=>{
                        console.log(resp)
                        this.lessons.splice(key,1)
                    }).catch(error=>{
                        console.log(error)
                    })
                }
            },
            updateLesson(lesson){
                let seriesId=this.series_id;
                this.$emit('update_lession',{lesson,seriesId})
            }
        }
    }
</script>