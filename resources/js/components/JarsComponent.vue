<template>
    <div>
        <div class="row">
            <div class="col-12 text-center mb-4">
                <p class="font-size-20">Шаг 1: Добавление банок</p>
            </div>
            <div class="col-lg-3 col-12" v-for="(jar, index) in jars">
                <div class="p-4 text-center">
                    <img class="h-auto" style="width: 60px;" v-if="jar.size >= 1000 && jar.size != null" :src="storage_url + '/image/large.svg'" alt="">
                    <img class="h-auto" style="width: 60px;" v-if="jar.size < 1000 && jar.size >= 500 && jar.size != null" :src="storage_url + '/image/medium.svg'" alt="">
                    <img class="h-auto" style="width: 60px;" v-if="jar.size < 500" :src="storage_url + '/image/small.svg'" alt="">
                    <i class="fas fa-times-circle text-danger fa-2x position-absolute" style="top:0%; right: 30%; cursor: pointer;"  v-if="jars.length > 1"  v-on:click="removeJar(index)"></i>
                </div>
                <div class="form-group">
                    <label class="font-size-12" :for="'name-' + index">Введите номер банки</label>
                    <input type="text" class="form-control font-size-12 mb-2" :id="'name-' + index" v-model="jar.name">

                    <label class="font-size-12" :for="'size-' + index">Введите объем банки (в граммах)</label>
                    <input type="number" class="form-control font-size-12"  onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43' :id="'size-' + index" v-model="jar.size">
                </div>
            </div>
            <div class="col-lg-3 col-12 p-5">
                <div class="d-flex align-items-center justify-content-center" style="border: 1px dashed #000000; border-radius: 20px; height:200px;">
                    <i class="fas fa-plus-circle text-success fa-3x" style=" cursor: pointer;" v-on:click="addJar"></i>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="jars != null && jars[0].name != null && jars[0].size != null">
            <button class="btn btn-success px-5 py-2" v-on:click="saveJars">Сохранить все</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "JarsComponent",
        data: function () {
            return {
                storage_url: window.location.origin,
                jars:null,
            }
        },

        mounted () {
            this.check();
        },

        methods: {
            check: function () {
                this.jars = this.$store.state.jars;
            },

            addJar: function () {
                this.jars.push({name: null, size: null});
            },

            removeJar: function (index) {
                this.jars.splice(index,1);
            },

            saveJars: function () {
                var ids = [];
                var jars = this.jars;
                jars.forEach(function callback(item){
                    if (parseInt(item.size) == 0 || item.size == null){
                        ids.push(jars.indexOf(item));
                    }
                });
                for (var i = ids.length -1; i >= 0; i--){
                    jars.splice(ids[i],1);
                }
                this.$store.state.stage = 2;
            }
        }
    }
</script>

<style scoped>

</style>