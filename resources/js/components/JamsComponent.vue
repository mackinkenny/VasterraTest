<template>
    <div>
        <div class="row">
            <div class="col-12 text-center mb-4">
                <p class="font-size-20">Шаг 2: Добавление варенья</p>
            </div>
            <div class="col-lg-3 col-12" v-for="(jam, index) in jams">
                <div class="p-4 text-center">
                    <img class="h-auto" style="width: 60px;" :src="storage_url + '/image/jam.svg'" alt="">
                    <i class="fas fa-times-circle text-danger fa-2x position-absolute" style="top:0%; right: 30%; cursor: pointer;"  v-if="jams.length > 1"  v-on:click="removeJam(index)"></i>
                </div>
                <div class="form-group">
                    <label class="font-size-12" :for="'name-' + index">Введите название варенья</label>
                    <input type="text" class="form-control font-size-12 mb-2" :id="'name-' + index" v-model="jam.name">

                    <label class="font-size-12" :for="'size-' + index">Введите объем приготовленного варенья (в граммах)</label>
                    <input type="number" class="form-control font-size-12"  onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43' :id="'size-' + index" v-model="jam.size">
                </div>
            </div>
            <div class="col-lg-3 col-12 p-5">
                <div class="d-flex align-items-center justify-content-center" style="border: 1px dashed #000000; border-radius: 20px; height:200px;">
                    <i class="fas fa-plus-circle text-success fa-3x" style=" cursor: pointer;" v-on:click="addJam"></i>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="jams != null && jams[0].name != null && jams[0].size != null">
            <button class="btn btn-success px-5 py-2" v-on:click="saveJams">Залить варенье в банки</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "JamsComponent",
        data: function () {
            return {
                storage_url: window.location.origin,
                jams: null,
            }
        },

        mounted () {
            this.check();
        },

        methods: {
            check: function () {
                this.jams = this.$store.state.jams;
            },

            addJam: function () {
                this.jams.push({name: null, size: null});
            },

            removeJam: function (index) {
                this.jams.splice(index,1);
            },

            saveJams: function () {
                var ids = [];
                var jams = this.jams;
                jams.forEach(function callback(item){
                    if (parseInt(item.size) == 0 || item.size == null){
                        ids.push(jams.indexOf(item));
                    }
                });
                for (var i = ids.length -1; i >= 0; i--){
                    jams.splice(ids[i],1);
                }
                this.$store.state.stage = 3;
            }
        }
    }
</script>

<style scoped>

</style>