<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Formulario</div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-lg-4 mt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombres</span>
                                    </div>
                                    <input v-model="nombre" type="text" class="form-control" aria-label="Nombres" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Apellidos</span>
                                    </div>
                                    <input v-model="apellidos" type="text" class="form-control" aria-label="Apellidos" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Edad</span>
                                    </div>
                                    <input v-model="edad" @input="soloNumeros" type="text" class="form-control" aria-label="Edad" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Profesion</label>
                                    </div>
                                    <select class="custom-select" v-model="profesion">
                                        <option v-for="(item, key) in profesiones">{{ item }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <button type="button" class="btn btn-success" @click="confirmarGuardarDatos">Guardar</button>
                            </div>
                            <div class="col-lg-4 mt-2"></div>
                            <div class="col-lg-4 mt-2">
                                <b-button v-b-toggle.collapse-1 variant="primary">Agregar Profesiones</b-button>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <b-collapse id="collapse-1" class="mt-2">
                                    <b-card>
                                        <div class="row">
                                            <div class="col-lg-12 mt-2">
                                                <p class="card-text">Agregue una nueva profesion</p>
                                            </div>                                            
                                            <div class="col-lg-6 mt-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Descripcion</span>
                                                    </div>
                                                    <input v-model="nuevaprofesion" type="text" class="form-control" aria-label="Descripcion" aria-describedby="inputGroup-sizing-default">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mt-2">
                                                <button type="button" class="btn btn-success" @click="agregarNuevaProfesion">Guardar</button>
                                            </div>
                                        </div>
                                    
                                    </b-card>
                                </b-collapse>
                            </div>


                            <div class="col-lg-12 mt-4">
                                <div class="overflow-auto">
                                    <b-table
                                    striped 
                                    hover 
                                    responsive 
                                    :items="items"
                                    :fields="fields" 
                                    :per-page="perPage"
                                    :current-page="currentPage"
                                    small 
                                    show-empty 
                                    >
                                    <template v-slot:empty="scope">
                                        <h6>No hay datos para mostrar</h6>
                                    </template>
                                    <template v-slot:emptyfiltered="scope">
                                        <h6>No hay datos para mostrar</h6>
                                    </template>
                                    <template v-slot:cell(Eliminar)="data">
                                        <button type="button" class="btn btn-danger text-white" @click="confirmarEliminarRegistro(data.value);">X</button>
                                    </template>
                                    </b-table>
                                    <b-pagination
                                    v-model="currentPage"
                                    :total-rows="rows"
                                    :per-page="perPage"
                                    aria-controls="my-table" 
                                    class="float-right" 
                                    ></b-pagination>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },
        data(){
            return {
                nombre:'', 
                apellidos:'', 
                edad:'',
                profesion:'',
                profesiones:[
                    'Programador', 
                    'Mecanico', 
                    'Ingeniero', 
                    'Petrolero', 
                    'Soldador'
                ],
                perPage: 10,
                currentPage: 1,            
                items: [],
                fields:['Nombre', 'Apellidos', 'Edad', 'Profesion', 'Eliminar'],
                nuevaprofesion:''
            }            
        },
        computed: {
            rows() {
            return this.items.length
            }
        },
        methods:{
            agregarNuevaProfesion(){
                if(!this.nuevaprofesion || this.nuevaprofesion==""){
                    this.$toasted.error('- La descripcion de la nueva profesion no puede estar vacia').goAway(3000);  
                    return; 
                }
                let nuevaDescripcion=this.capitalize(this.nuevaprofesion);
                let index=this.profesiones.indexOf(nuevaDescripcion);
                if(index!=-1){
                    this.$toasted.error('- La profesion ingresada ya existe').goAway(3000);  
                    return; 
                }
                this.profesiones.push(nuevaDescripcion);
                this.nuevaprofesion='';
                this.$toasted.success('- La nueva profesion fue ingresada exitosamente').goAway(3000);
            },
            capitalize(s){
                return s.charAt(0).toUpperCase() + s.slice(1);
            }, 
            confirmarEliminarRegistro(index){
                this.$bvModal.msgBoxConfirm('Desea eliminar el registro actual? ', {
                    title: 'Eliminar Registro',
                    size: 'md',
                    buttonSize: 'md',
                    okVariant: 'success',
                    okTitle: 'Eliminar',
                    cancelVariant: 'danger',
                    cancelTitle: 'Cancelar',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                    })
                    .then(value => {
                        if(value){
                            this.items.splice(index, 1);
                            this.$toasted.success('- El registro fue eliminado exitosamente').goAway(3000);   
                        }            
                    })
                    .catch(err => {
                        // An error occurred
                });
            },
            confirmarGuardarDatos(){
                if(!this.nombre){
                    this.$toasted.error('- El nombre no puede estar vacio').goAway(3000);  
                    return; 
                }
                if(!this.apellidos){
                    this.$toasted.error('- Los apellidos no pueden estar vacios').goAway(3000);  
                    return;
                }
                if(!this.edad || isNaN(this.edad) || (parseInt(this.edad)<=0 || parseInt(this.edad)>100)){
                    this.$toasted.error('- La edad ingresada no es valida').goAway(3000);  
                    return;
                }
                if(!this.profesion){
                    this.$toasted.error('- La profesion no puede estar vacia').goAway(3000);  
                    return;
                }
                this.$bvModal.msgBoxConfirm('Desea guardar los datos actuales? ', {
                    title: 'Confirmación',
                    size: 'md',
                    buttonSize: 'md',
                    okVariant: 'success',
                    okTitle: 'Aceptar',
                    cancelVariant: 'danger',
                    cancelTitle: 'Cancelar',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                    })
                    .then(value => {
                        if(value){
                            this.guardarDatos();
                        }            
                    })
                    .catch(err => {
                        // An error occurred
                });
            },
            guardarDatos(){                
                axios.post('api/formulario', {
                    nombre:this.nombre,
                    apellidos:this.apellidos,
                    edad:this.edad, 
                    profesion:this.profesion
                }).
                    then(res=>{
                        this.items.push({
                            'Nombre':this.nombre, 
                            'Apellidos':this.apellidos, 
                            'Edad':this.edad, 
                            'Profesion':this.profesion, 
                            'Eliminar':parseInt(this.items.length)
                        });
                        this.nombre='';
                        this.apellidos='';
                        this.edad='';
                        this.profesion='';
                        this.$toasted.success('- Los datos fueron guardados exitosamente').goAway(3000);   
                    }).catch(error=>{
                        for (const a in error.response.data.errors) {
                            this.$toasted.error(error.response.data.errors[a]).goAway(3000); 
                        }                        
                });
            },
            soloNumeros(){
                let reg = new RegExp('^[0-9]+$');
                if(!reg.test(this.edad)){
                    this.edad='';
                }
                if(parseInt(this.edad)<=0 || parseInt(this.edad)>100){
                    this.edad='';
                }
            }
        }
    }
</script>
