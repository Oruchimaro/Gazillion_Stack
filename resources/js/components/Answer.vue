<template>
    <div class="media post">
        <!-- Vote Controls section -->
        <vote :model="answer" name="answer"></vote>
        <!-- End Vote Controls section -->
    
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update" >
                <textarea class="form-control" v-model="body" rows="10" required></textarea>
                <button class="btn btn-sm btn-outline-info" :disabled="isInvalid" >Update</button>
                <button class="btn btn-sm btn-outline-danger" @click="cancel" type="button" >Cancel</button>
            </form>
            <div v-if="!editing">
                <div v-html="bodyHtml" ></div>
                <div class="row" >
                    <div class="col-4" >
                        <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info"> Edit </a>
                        <!-- DOCUMENTATION.md , line: 80 -->
                        <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                    </div>
                    <div class="col-4"></div>
        
                    <div class="col-4">
                        <user-info v-bind:model="answer" label="Answered" ></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import modification from '../mixins/modification';
export default {
    props: [
        'answer',
    ],

    mixins: [ modification],


    components: {
        Vote,
        UserInfo
    },

    data() {
        return {
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id:this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null,
        }
    },
    computed: {

        isInvalid() {
            return this.body.length < 10;
        },
        endpoint(){
            return `/questions/${this.questionId}/answers/${this.id}`;
        }
    },

    methods: {
        setEditCache(){
            this.beforeEditCache = this.body;
        },
        restoreFromCache(){
            this.body = this.beforeEditCache;
        },

        payload(){
            return {
                body: this.body,
            }
        },

        delete(){
            axios.delete(this.endpoint).then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timeout: 3000
                });
                this.$emit('deleted');
            });
        },

        
    }
}
</script>