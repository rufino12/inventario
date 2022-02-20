<template>
    <div class="container">
    <div class="modal" :class="{mostrar: modal}">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Calificar</h4>
                    <button @click="cerrarModal();"  type="button" class="close" data-dismiss="modal">
                    &times;
                    </button>
                </div>
                <div class="modal-body">
                <select v-model="product.calific"  class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select></div>
                <div class="modal-footer">
                    <button @click="cerrarModal();" type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                    </button>
                    <button  @click="guardar();" type="button" class="btn btn-success" data-dismiss="modal">
                    Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12 p-3">
                <div class="card">
                    <div class="row p-4" >
                        <div class="col-2 border"></div>
                        <div class="col-8">
                            <p class="text-succes">{{products.name}}</p>
                            <p class="text-succes">$ {{products.price}}</p>
                            <div v-if="products.categories">
                                <span class="bg-dark ms-2 text-light" 
                                v-for="category in products.categories">{{category.name}}</span>
                            </div>
                            Calificación: {{items}}
                            <p class="text-succes">{{ (products.status==true)? 'Disponible- in stock':'Agotado' }}</p>
                            <p class="text-succes">{{products.name}}</p>
                            <button @click="modificar=false; abrirModal();" type="button" class="btn btn-primary my-4">Calificar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["id"],
        data() {
            return {
                product:{
                    calific:1,
                    id:this.id
                },
                
                modificar:true,
                modal:0,
                count:0,
                items:0,
                products: []
            }
                
        },

        methods: {
            abrirModal(data={}){
                this.modal=1;
                
            },
            async guardar() {
                const res = await axios.post('/api/qualification/', this.product);
                this.items=0;
                this.cerrarModal();
                this.listar();
            
            },
            cerrarModal(){
                this.modal=0;
            },
            async listar() {
                const res = await axios.get('/api/product/'+this.id);
                this.products = res.data;
                this.products.qualification.forEach((value, index) => {
                    this.count++
                    this.items=this.items+value.qualification
                });
                this.items=this.items/this.count;
            },
            async qualification(id){

            },

    },
    created() {
            this.listar();
        }
    }
</script>
