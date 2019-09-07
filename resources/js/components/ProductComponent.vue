<template>
	<div id="myproduct">
		<div class="row mt-2 mb-2">
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" v-model="search" class="form-control">
					<div class="input-group-prepend">
						<button @click.prevent="searchProduct()" class="btn btn-primary"><i class="fas fa-search"></i></button>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart">
				  <i class="fas fa-shopping-cart"></i> <span class="badge badge-light">{{badge}}</span>
				</button>
				<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Your Cart</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <table class="table table-striped text-left table-sm">
				        	<tbody>
				        		<tr v-for="(cart, n) in carts" v-bind:key="cart.id">
				        			<td>{{cart.name}}</td>
				        			<td> $ {{cart.price}}</td>
				        			<td width="100"><input type="text" readonly class="form-control" v-model="cart.amount"></td>
				        			<td width="60">
				        				<button @click="removeCart(n)" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i></button>
				        			</td>
				        		</tr>
				        	</tbody>	
				        </table>
				      </div>
				      <div class="modal-footer">
				      	Total Price: $ {{totalprice}} &nbsp;
				        <a href="/checkout" class="btn btn-secondary">Checkout</a>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div v-if="showsearch==true">
					<div class="row">
						<div v-for="cari in caris" :key="cari.id" class="col-md-6">
							<div class="card mb-4">
								<img :src="cari.image" :alt="cari.name" class="card-img-top">
								<div class="card-body">
									<h4>{{cari.name }}</h4>
									<p>{{cari.description }}</p>
									<div class="row">
										<div class="col-md-6">Stock {{cari.amount}}</div>
										<div class="col-md-6">USD {{cari.price}}</div>
									</div>
									<p class="text-right mt-2">
										<button @click="viewLink(cari.id)" class="btn btn-primary">View</button>
										<button @click="editProduct(cari)" class="btn btn-warning">Edit</button>
										<button @click="deleteProduct(cari.id)" class="btn btn-danger">Delete</button>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div v-if="showsearch==false">
					<div class="row">
						<div v-for="product in products" v-bind:key="product.id" class="card card-body col-md-6">
							<h4>{{product.name }}</h4>
							<p>{{product.description }}</p>
							<div class="row">
								<div class="col-md-6">Stock {{product.amount}}</div>
								<div class="col-md-6">USD {{product.price}}</div>
							</div>
							<p class="text-right mt-2">
								<!-- <input type="number" v-model="quantity" style="width: 60px;"> -->
								<!-- <button @click="addCart(product)" class="btn btn-primary">Add to Cart</button> -->
								<button @click="viewLink(product.id)" class="btn btn-primary">View</button>
								<button @click="editProduct(product)" class="btn btn-warning">Edit</button>
								<button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
							</p>
						</div>
					</div>
				</div>	
				<div class="row mt-2">
					<div class="colmd-8">
						<nav>
							<ul class="pagination">
								<li v-bind:class="{disabled:!pagination.first_link}" class="page-item"><a @click="viewProduct(pagination.first_link)" class="page-link">&laquo;</a></li>
								<li v-bind:class="{disabled:!pagination.prev_link}" class="page-item"><a @click="viewProduct(pagination.prev_link)" class="page-link">&lt;</a></li>
								<li v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active:pagination.current_page == n}" class="page-item"><a @click="viewProduct(pagination.path_page + n)" class="page-link">{{n}}</a></li>
								<li v-bind:class="{disabled:!pagination.next_link}" class="page-item"><a @click="viewProduct(pagination.next_link)" class="page-link">&gt;</a></li>
								<li v-bind:class="{disabled:!pagination.last_link}" class="page-item"><a @click="viewProduct(pagination.last_link)" class="page-link">&raquo;</a></li>
							</ul>
						</nav>
					</div>

					<div class="col-md-4">
						Page: {{pagination.from_page}} - {{pagination.to_page}}
						Total: {{pagination.total_page}}
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<form action="">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" v-model="product.name">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea type="text" class="form-control" v-model="product.description"></textarea>
					</div>
					<div class="form-group">
						<label>Amount</label>
						<input type="number" class="form-control" v-model="product.amount">
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="number" class="form-control" v-model="product.price">
					</div>
					<button v-if="add" @click.prevent="addProduct()" class="btn btn-primary">Add Product</button>
					<button v-if="edit" @click.prevent="updateProduct(product.id)" class="btn btn-primary">Update Product</button>
					<button @click.prevent="clearProduct()" class="btn btn-info">Clear</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			products: [],
			product: {
				id: '',
				name: '',
				description: '',
				amount: '',
				price: ''
			},
			add : true,
			edit: false,
			pagination: {},
			carts: [],
			cartadd: {
				id: '',
				name: '',
				price: '',
				amount: ''
			},
			badge: '0',
			quantity: '1',
			totalprice: '0',
			search: '',
			showsearch: false,
			caris: []
		}
	},
	created() {
		this.viewProduct()
		this.viewCart()
	},
	methods: {
		searchProduct(){
			fetch('/api/product/search?q=' + this.search)
			.then(res => res.json())
			.then(res => {
				this.caris = res
				this.search = ''
				this.showsearch = true
			})
			.catch(err => {
				console.log(err)
			})
		},
		viewCart(){
			if(localStorage.getItem('carts')){
				this.carts = JSON.parse(localStorage.getItem('carts'))
				this.badge = this.carts.length
				this.totalprice = this.carts.reduce((total, item) => {
					return total + item.amount * item.price
				}, 0)
			}
		},
		addCart(pro){
			this.cartadd.id = pro.id
			this.cartadd.name = pro.name
			this.cartadd.price = pro.price
			this.cartadd.amount = this.quantity
			this.carts.push(this.cartadd)
			this.cartadd = {}
			this.storeCart()
		},
		removeCart(pro){
			this.carts.splice(pro, 1)
			this.storeCart()
		},
		storeCart(){
			let parsed = JSON.stringify(this.carts)
			localStorage.setItem('carts', parsed)
			this.viewCart()
		},
		viewProduct(pagi) {
			pagi = pagi || 'api/products'
			fetch(pagi)
			.then(res => res.json())
			.then(res => {
				console.log(res)
				this.products = res.data
				this.pagination = {
					current_page: res.meta.current_page,
					last_page: res.meta.last_page,
					from_page: res.meta.from,
					to_page: res.meta.to,
					total_page: res.meta.total,
					path_page: res.meta.path+"?page=",
					first_link: res.links.first,
					last_link: res.links.last,
					prev_link: res.links.prev,
					next_link: res.links.next
				}
			})
			.catch(err => console.log(err))
			
		},
		addProduct() {
			fetch('api/products', {
				method: 'post',
				body: JSON.stringify(this.product),
				headers: {
					'content-type': 'application/json'
				}
			})
			.then(res => res.json())
			.then(res => {
				swal('Successful!', 'Product has been added', 'success')
				this.product.name = ''
				this.product.description = ''
				this.product.price = ''
				this.product.amount = ''
				this.viewProduct()
			})
			.catch(err => {
				console.log(err)
				swal('Failed!', 'Product failed to add', 'error')
			})
		},
		editProduct(pro) {
			this.add = false
			this.edit = true
			this.product.id = pro.id
			this.product.name = pro.name
			this.product.description = pro.description
			this.product.price = pro.price
			this.product.amount = pro.amount
		},
		updateProduct(id) {
			fetch(`api/products/${id}`, {
				method: 'put',
				body: JSON.stringify(this.product),
				headers: {
					'content-type': 'application/json'
				}
			})
			.then(res => res.json())
			.then(res => {
				swal('Successful!', 'Product has been updated', 'success')
				this.add = true
				this.edit = false
				this.product.name = ''
				this.product.description = ''
				this.product.price = ''
				this.product.amount = ''
				this.viewProduct()
			})
			.catch(err => {
				console.log(err)
				swal('Failed!', 'Product failed to update', 'error')
			})
		},
		deleteProduct(id) {
			swal({
				title: 'Are you sure?',
				text: 'Product will be deleted',
				icon: 'warning',
				buttons: true,
				dangerMode: true
			}).then(willdelete => {
				if(willdelete){
					fetch(`api/products/${id}`, {
						method: 'delete'
					})
					.then(res => res.json())
					.then(res => {
						swal('Successful!', 'Product has been deleted', 'success')
						this.viewProduct()
					})
					.catch(err => {
						console.log(err)
						swal('FAiled!', 'Product failed to delete', 'error')
					})
				}
			})
			
		},
		clearProduct(){
			this.add = true
			this.edit = false
			this.product.id = ''
			this.product.name = ''
			this.product.description = ''
			this.product.price = ''
			this.product.amount = ''
		},
		viewLink(mylink){
			location.href = '/detail/' + mylink
		}
	}
}
	
</script>

<style scoped>
	.product-item {
		width: 350px;
		float: left;
	}
</style>