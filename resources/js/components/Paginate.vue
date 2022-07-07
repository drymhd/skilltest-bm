<template>
	<div :class="[{'card card-custom card-stretch gutter-b': useCard}, classHead]">
		<div class="md-12 align-items-center" style="padding: 25px; padding-bottom: 0px" :class="{'p-0': !useCard}">
			<div class="row">
				<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
					<div class="form-group row" style="margin-bottom: 0px">
						<label class="col-md-4 col-form-label">Display </label>
						<div class="col-md-7">
							<select class="form-control" v-model="per" @change="reload()">
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4 kt-margin-b-20-tablet-and-mobile" style="margin-left: auto;">
					<form :id="`searchBox`+id" @submit.prevent="reload(null, false)" class="input-icon input-icon-right">
						<div class="input-icon input-icon-right">
							<input type="text" class="form-control" style="padding-left: 1rem;" @input="search" v-model="text" placeholder="Search...">
						    <span role="button" @click="reload(null, false)"><i class="flaticon2-search-1 icon-md"></i></span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="card-body pt-2" :class="{'p-0': !useCard}">
			<div class="table-responsive">
				<table :id="id" :class="classx">
					<thead>
						<tr>
							<th :class="((column.class) ? column.class : false)" :style="((column.style) ? column.style : '')" v-for="column in columns">{{ column.name }}</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr v-if="loading"><td :colspan='columns.length'>Proccessing...</td></tr> -->
						<tr v-if="notfound"><td :colspan='columns.length'>No result found</td></tr>
						<tr v-if="!notfound" v-for="(data, ind) in datas">
							<template v-for="(column, i) in columns">
								<td v-html="((column.data.indexOf('.') == -1) ? ((data[column.data]) ? data[column.data] : ((column.default) ? column.default : '-')) : getData(column, i, ind) )"></td>
							</template>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-5">
					<div class="dataTables_info" id="table_user_info" role="status" aria-live="polite">Showing {{((paginate.from) ? paginate.from : 0)}} to {{((paginate.to) ? paginate.to : 0)}} of {{((paginate.total) ? paginate.total : 0)}} entries</div>
				</div>
				<div class="col-sm-12 col-md-7">
					<div class="dataTables_paginate paging_simple_numbers" id="table_user_paginate">
						<ul class="pagination" style="justify-content: flex-end;">
							<li :class="{disabled: paginate.prev_page_url == null}" class="paginate_button page-item previous" v-on:click=" paginate.prev_page_url != null && reload(paginate.prev_page_url)">
								<a href="javascript:void(0)" class="page-link" style="z-index: 0;">Previous</a>
							</li>
							<div v-for="nomor in nomors">
								<li :class="['paginate_button', 'page-item', {active: nomor.page == paginate.current_page ? 'true' : ''}]" v-on:click="reload(nomor.path)">
									<a href="javascript:void(0)" class="page-link" style="z-index: 0;">{{nomor.page}}</a>
								</li>
							</div>
							<li :class="{disabled: paginate.next_page_url == null}" class="paginate_button page-item next" v-on:click="paginate.next_page_url != null && reload(paginate.next_page_url)">
								<a href="javascript:void(0)" class="page-link" style="z-index: 0;">Next</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['id', 'url', 'columns', 'classx', 'callback', 'post', 'useCard', 'classHead'],
		data() {
			return {
				datas: [],
				nomors: [],
				text: '',
				paginate: {},
				loading: false,
				notfound: false,
				per: 10,
			}
		},
		methods: {
			getData(s, index, ind) {
				var app = this;
				s = s.data.split('.');
				var p = 'app.datas[ind]';
				for(var i = 0; i<s.length; i++){
					p = p+'["'+s[i]+'"]';
				}
				var d = "";
				try {
					d = eval(p);
				}catch(e) {
					d = '';
				}
				return d;
			},
			reload(url=null, search=false){
				var app = this;
				if(url == null){
					url = app.url
				}
				if(!search){
					// KTApp.block("#"+app.id,{
					// 	overlayColor:"#000000",
					// 	type:"v2",
					// 	state:"primary",
					// 	message:"Processing...",
					// 	opacity: 0.2
					// });
				}
				app.loading = true;
				app.$http({
		            url: url,
		            method: 'POST',
		            data: {search: app.text, per: app.per, ...app.post}
		        }).then((res) => {
		        
	            	$('#icon-search').removeClass('kt-spinner kt-spinner--v2 kt-spinner--sm kt-spinner--success');
		        	$('#icon-search').addClass('la la-search');
					app.loading = false;
					app.notfound = false;
		        	app.nomors = [];
		            app.datas = res.data.data;
		            app.paginate = res.data;

                    if(app.datas.length == 0){
						app.notfound = true;
            		}else{
						app.notfound = false;
            		};
            		app.nomor();
		        }).catch((error) => {
		        	alert("Server Error: "+error.response.data.message);
					app.loading = false;
					app.notfound = true;
		        	// $('#'+app.id).find('tbody').append("<tr id='notFound"+app.id+"'><td colspan='"+app.columns.length+"'>Error : "+error.response.data.message+"</td></tr>");
		        });
			},
            nomor(){
            	var app = this;
            	var lastPage = app.paginate.last_page;
                var noPage = app.paginate.current_page;
                var path = app.paginate.path;
            	var i;
        		if(noPage < 5){
        			for(i = 1; i <= 5; i++){
        				if(i<=lastPage){
        					var a = {page: i, path: path+'?page='+i};
        					app.nomors.push(a);
            			}
        			}
        		}else{
        			var from = noPage-2;
        			var to = noPage+2;
        			for(i = from; i <= to; i++){
        				if(i<=lastPage){
        					var a = {page: i, path: path+'?page='+i};
        					app.nomors.push(a);
            			}
        			}
        		};
            },
            search: _.debounce(function() {
            	this.reload(null, true);
            }, 500),
		},
		watch: {
			text: function() {
				$('#icon-search').removeClass('la la-search');
            	$('#icon-search').addClass('kt-spinner kt-spinner--v2 kt-spinner--sm kt-spinner--success');
            	if(!this.loading){
	            	this.loading = true;
            	}
			}
		},
		mounted() {
			this.reload();
			if(this.callback){
				this.callback();
			}
		}
	}
</script>