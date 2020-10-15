<template>
    <div class="modal fade bs-example-modal-sm" id="createLessons" tabindex="-1" role="dialog"
         aria-labelledby="createLessons"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Lesson</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Lesson Title" v-model="lesson.title">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Vimeo Video ID" v-model="lesson.video_id">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Episode Number" v-model="lesson.episode_number">
                    </div>
                    <div class="form-group">
                        <textarea cols="30" rows="10" class="form-control" placeholder="Description"
                                  v-model="lesson.description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"   v-model="lesson.premium"> Premium: {{lesson.premium}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="updateLesson" v-if="editing">Update
                        Lesson
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="saveLesson" v-else>Add Lesson</button>
                </div>
            </div>
        </div>
    </div>


</template>
<script>
    import Axios from 'axios';

    class Lesson {
        constructor(lesson) {
            this.title = lesson.title || '';
            this.description = lesson.description || '';
            this.video_id = lesson.video_id || '';
            this.episode_number = lesson.episode_number || '';
            this.premium = lesson.premium || false;
        }
    }

    export default {
        mounted() {
            this.$parent.$on('create_new_lesson', (seriesId) => {
                this.editing = false;
                this.seriesId = seriesId;
                this.lesson = new Lesson({})
                $('#createLessons').modal();
            });
            this.$parent.$on('update_lession', ({lesson, seriesId}) => {
                this.editing = true;
                this.seriesId = seriesId;
                this.lessonId = lesson.id;
                this.lesson = new Lesson(lesson);
                $('#createLessons').modal();
            })

        },
        data() {
            return {
                lesson: {
                    title: '',
                    description: '',
                    video_id: '',
                    episode_number: '',
                    premium: false
                },
                seriesId: '',
                editing: false,
                lessonId: null
            }
        },
        methods: {
            saveLesson() {
                Axios.post(`/admin/${this.seriesId}/lessons`, this.lesson).then(resp => {
                    this.$parent.$emit('created_lesson', resp.data);
                    $('#createLessons').modal('hide');
                }).catch(error => {
                    window.handleError(error)
                })
            },
            updateLesson() {
                Axios.put(`/admin/${this.seriesId}/lessons/${this.lessonId}`, this.lesson).then(resp => {
                    $('#createLessons').modal('hide');
                    this.$parent.$emit('lesson_updated', resp.data);
                }).catch(error => {
                   window.handleError(error)
                })
            }
        }
    }
</script>