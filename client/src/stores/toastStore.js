import { defineStore } from 'pinia';

export const useToastStore = defineStore('toast', {
    state: () => ({
        messages: [], // Itt tároljuk az éppen aktív üzeneteket
        type: null
    }),
    actions: {
        show( type = 'Success') {
            // 5 másodperc után automatikusan töröljük
            this.type = type;
            setTimeout(() => {
                // this.messages = this.messages.filter(m => m.id !== id);
                this.messages = [];
                this.type = null;
            }, 5000);
        },
        close(){
            this.messages = [];
        }
    }
});
