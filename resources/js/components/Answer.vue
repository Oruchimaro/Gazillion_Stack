<template>
    <div class="media post">
        <!-- Vote Controls section -->
        <vote :model="answer" name="answer"></vote>
        <!-- End Vote Controls section -->
    
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update" >
                <textarea class="form-control" v-model="body" rows="10" required></textarea>
                <button class="btn btn-sm btn-outline-info" :disabled="isInvalid" >Update</button>
                <button class="btn btn-sm btn-outline-danger" @click="cansel" type="button" >Cansel</button>
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
export default {
    props: [
        'answer',
    ],

    data() {
        return {
            editing:false,
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
        edit(){
            this.beforeEditCache = this.body;
            this.editing = true;
        },
        cansel(){
            this.body = this.beforeEditCache;
            this.editing = false;
        },
        update() {
            axios.patch(this.endpoint, {
                body: this.body,

            }).then(res => {
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                this.$toast.success(res.data.message, "Success", { timeout: 3000 });

            }).catch(err => {
                this.$toast.error(err.response.data.message, "Error", { timeout: 3000 });
            });
        },

        destroy(){

             this.$toast.question('Are you sure about that?',"Confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>',(instance, toast) => {
                        axios.delete(this.endpoint)
                        .then(res => {
                            //utilizing custom events
                            this.$emit('deleted');
                        });
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });
        },

        
    }
}
</script>