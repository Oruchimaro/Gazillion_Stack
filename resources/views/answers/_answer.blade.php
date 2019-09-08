<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <!-- Vote Controls section -->
        <vote :model="{{ $answer }}" name="answer"></vote>
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
                        @can('update', $answer) 
                            <a @click.prevent="edit" class="btn btn-sm btn-outline-info"> Edit </a>
                        @endcan

                        @can('delete', $answer) 
                            {{-- DOCUMENTATION.md , line: 80 --}}
                            <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        @endcan
                    </div>
                    <div class="col-4"></div>
        
                    <div class="col-4">
                        <user-info v-bind:model="{{ $answer }}" label="Answered" ></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>