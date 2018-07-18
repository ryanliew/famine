<template>
	<div>
		<div class="p-4">
			<label for="team">Select team</label>
			<select id="team" class="custom-select" v-model="selectedTeam" @change="getTeam">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
			</select>
		</div>
		<div v-if="team">
			<div class="row align-items-center">
				<div class="col-3">
					<img src="img/water.png" class="resource-img" style="width:20px;">
				</div>
				<div class="col-2" :style="waterAmountStyle">
					<b>{{ team.water }}</b>
				</div>
				<div class="col-4">
					<input type="number" class="form-control" v-model="addWater">
				</div>
				<div class="col-3">
					{{ newWater }}
				</div>
			</div>
			<div class="row align-items-center mt-4">
				<div class="col-3">
					<img src="img/bread.png" class="resource-img" style="width:30px;">
				</div>
				<div class="col-2" :style="foodAmountStyle">
					<b>{{ team.food }}</b>
				</div>
				<div class="col-4">
					<input type="number" class="form-control" v-model="addFood">
				</div>
				<div class="col-3">
					{{ newFood }}
				</div>
			</div>
			<div class="row align-items-center mt-4">
				<div class="col-3">
					<img src="img/money.png" class="resource-img" style="width:40px;">
				</div>
				<div class="col-2">
					<b>{{ team.money }}</b>
				</div>
				<div class="col-4">
					<input type="number" class="form-control" v-model="addMoney">
				</div>
				<div class="col-3">
					{{ newMoney }}
				</div>
			</div>

			<button type="button" class="btn btn-primary mt-3" @click="updateResource" v-html="buttonContent" :disabled="is_loading"></button>
		</div>
		
		<div class="alert alert-success" v-if="success">Resource updated</div>
	</div>
</template>

<script>
	export default {
		props: [''],

		data() {
			return {
				selectedTeam: '',
				addFood: 0,
				addMoney: 0,
				addWater: 0,
				team: '',
				success: false,
				is_loading: false
			};
		},

		methods: {
			getTeam() {
				axios.get('/team/' + this.selectedTeam)
					.then(response => this.setTeam(response))
					.catch(error => this.getTeam());
			},

			setTeam(response){
				this.success = false;
				this.team = response.data;
			},

			updateResource() {
				this.is_loading = true;
				axios.post("/team/" + this.selectedTeam, {money: this.newMoney, food: this.newFood, water: this.newWater})
					.then(response => this.onSuccess(response))
					.catch(error => this.updateResource());
			},

			onSuccess(response) {
				this.team.water = this.newWater;
				this.team.money = this.newMoney;
				this.team.food = this.newFood;
				this.addFood = 0;
				this.addMoney = 0;
				this.addWater = 0;
				this.is_loading = false;

				this.selectedTeam = '';
				this.team = '';

				this.success = true;
			}
		},

		computed: {
			newFood() {
				return this.team ? parseInt(this.team.food) + parseInt(this.addFood) : 0;
			},

			newMoney() {
				return this.team ? parseInt(this.team.money) + parseInt(this.addMoney) : 0;
			},

			newWater() {
				return this.team ? parseInt(this.team.water) + parseInt(this.addWater) : 0;
			},

			foodAmountStyle() {
	    		var color = 'green';

	    		if(this.team.food < 10)
	    			color = "red";
	    		else if(this.team.food < 30)
	    			color = "orange";

	    		return {
	    			color: color
	    		}
	    	},

	    	waterAmountStyle() {
	    		var color = 'green';

	    		if(this.team.water < 10)
	    			color = "red";
	    		else if(this.team.water < 30)
	    			color = "orange";
	    		return {
	    			color: color
	    		}
	    	},

	    	buttonContent() {
	    		return this.is_loading ? "<i class='glyphicon glyphicon-refresh forward-spin'></i>" : "Update"
	    	}
		}	
	}
</script>