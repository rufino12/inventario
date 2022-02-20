
<template>
    <div class="container">
    <button @click="modificar=false; abrirModal();" type="button" class="btn btn-primary my-4">Nuevo</button>

    <!-- The Modal -->
    <div class="modal" :class="{mostrar: modal}">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{tituloModal}}</h4>
                <button @click="cerrarModal();"  type="button" class="close" data-dismiss="modal">
                &times;
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="my-4">
              <label for="nombre">Nombre</label>
              <input v-model="product.name" type="text" class="form-control" id="name" placeholder="Nombre del Producto">
              <label for="nombre">Sku</label>
              <input v-model="product.sku" type="text" class="form-control" id="sku" placeholder="Sku del Producto">
              <label for="nombre">Precio</label>
              <input v-model="product.price" type="number" min="0" class="form-control" id="name" placeholder="Precio del Producto">
              <label for="nombre">Stock</label>
              <input v-model="product.amount" type="number" min="0" class="form-control" id="name" placeholder="Stock del Producto">
              
              <label for="nombre">Categories</label>
              <select v-model="product.category"  class="form-control" >
                <option v-for="category in categories" v-bind:value="category.id" >
                    {{ category.name }}
                </option>
                </select>
                <div class="form-check form-switch">
                    <input v-model="product.status"  class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">inventario</label>
                </div>
            </div> 
            </div>

            <!-- Modal footer -->
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
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col"></th>
                <th scope="col">Inventario</th>
                <th scope="col" colspan="2" class="text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                <th scope="row">{{ product.id }}</th>
                <th><span class="text-primary">{{ product.name }}</span> <br>
                    <span class="text-secondary">{{ product.sku }}</span><br>
                    <span class="text-success">{{ (product.status==true)? 'In stock':'' }}</span><br>
                    <div v-if="product.categories">
                        <span class="bg-dark ms-2 text-light" 
                        v-for="category in product.categories">{{category.name}}</span>
                    </div>
                </th>
                <td>
                <div class="form-check form-switch">
                    <input v-model="product.status"  class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                </div></td>
                <td> 
                </td>
                <td class="text-center">
                    <span class="text-secondary">$ {{product.price}}</span><br>
                    <span class="text-success">{{ (product.status==true)? 'Disponible':'Agotado' }}</span><br>
                    
                    <button @click="eliminar(product.id)" class="btn btn btn-secondary mb-2">
                    Eliminar
                    </button><br>
                    <button   @click="view(product.id)" class="btn btn-success mb-2">
                    Detalle
                    </button>
                    <button  @click="modificar=true; abrirModal(product);" class="btn mb-2 btn-warning">Editar</button>
                </td>
                
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product:{
                    id:0,
                    sku:'',
                    name:'',
                    price:'',
                    amount:'',
                    status:0,
                    category:[]
                },
                categories:[],
                modificar:true,
                modal:0,
                tituloModal:'',
                products: [],
                pagination:{
                    page:1,
                    per_page:5,
                }
            };
        },
        methods: {
            async listar() {
                const res = await axios.get('/api/product');
                this.products = res.data;
                const cat = await axios.get('/api/category');
                this.categories= cat.data;
            },
            async eliminar(id) {
                const res = await axios.delete('/api/product/' + id);
                this.products = res.data;
                this.listar();
            },
            async view(id){
                window.location.href = '/detail/'+ id;
            },
            async inve(id){
                const res = await axios.get('/api/stock/'+ id);
                this.listar();
            },
            
            abrirModal(data={}){
                this.modal=1;
                if(this.modificar){
                    this.tituloModal="Modificar Producto";
                    this.product.id=data.id;
                    this.product.name=data.name;
                    this.product.sku=data.sku;
                    this.product.price=data.price;
                    this.product.amount=data.amount;
                    this.product.status=data.status;
                    
                    this.product.category=2;
                }else{
                    this.tituloModal="Crear Producto";
                }
            },
            async guardar() {
            if(this.product.id!=0){
                const res = await axios.put('/api/product/'+this.product.id, this.product);
                // console.log(this.id);
            }else{
                const res = await axios.post('/api/product/', this.product);
            }
            this.cerrarModal();
            this.listar();
            },
            cerrarModal(){
                this.modal=0;
            },
        },
        
        created() {
            this.listar();
        }
    }
</script>
<style>
  .mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(75, 56, 143, 0.705);
  }
</style>