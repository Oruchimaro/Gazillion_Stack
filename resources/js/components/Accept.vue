<template>
    <div>

        <a v-if="canAccept" title="Mark as best answer" :class="classes"
        @click.prevent="create" > 
            <i class="fas fa-check-double fa-2x "></i>                             
        </a>
        <a v-if="accepted" title="The owner accepted this answer as best" :class="classes" > 
            <i class="fas fa-check-double fa-2x "></i>                             
        </a>
    </div>
</template>

<script>
import  EventBus from '../event-bus';
export default {
    props: ['answer'],

    computed: {
        canAccept(){
            return this.authorize('accept', this.answer);
        },

        accepted(){
            return !this.canAccept && this.answer.isBest;
        },

        classes(){
            return [
                'mt-2',
                this.isBest ? 'vote-accepted' : '',
            ];
        }
    },

    data(){
        return {
            isBest: this.answer.is_best,
            id: this.answer.id
        }
    },

    methods: {

        create(){
            axios.post(`/answers/${this.id}/accept`)
            .then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timeOut: 3000,
                    position: 'center'
                });

                this.isBest = true;
                EventBus.$emit('accepted', this.id);
            })
        }
    },

    created(){
        EventBus.$on('accepted', id=> {
            this.isBest = (id === this.id) ;
        })
    }
}
</script>