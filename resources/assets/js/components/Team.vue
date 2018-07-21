<template>
	<div>
		<div class="team-name" @click="canInput = !canInput">
        	<span class="badge badge-primary">Team {{ team.id }}</span>
    	</div>

    	<div class="input-group mt-5" v-if="canInput">

    		<input class="form-control" v-model="resources" type="text"> 

    		<div class="input-group-append">
    			<button class="btn btn-primary" type="button" @click="calculate">Go</button>
    		</div>

    	</div>
    	<div v-else>
       		<div class="row justify-content-center">
            	<div class="col resource">
                	<h1 class="resource-amount" :style="waterAmountStyle">
                		<div v-if="!editWater" @click="editWater = !editWater">
                        	<img src="img/water.png" class="resource-img" style="width:20px;"> {{ team.water }}
                    	</div>
                    	<div class="input-group mt-3" v-else>

	                		<input class="form-control" v-model="water" type="text" @keyup.enter="calculateWater"> 

	                		<div class="input-group-append">
	                			<button class="btn btn-primary" type="button" @click="calculateWater">Go</button>
	                		</div>

	                	</div>
                	</h1>
            	</div>
        	</div>
        	<div class="row">
            	<div class="col resource">
                	<h1 class="resource-amount" :style="foodAmountStyle">
                		<div v-if="!editFood" @click="editFood = !editFood">
                    		<img src="img/bread.png" class="resource-img"> {{ team.food }}
                    	</div>
                    	<div class="input-group" v-else>

	                		<input class="form-control" v-model="food" type="text" @keyup.enter="calculateFood"> 

	                		<div class="input-group-append">
	                			<button class="btn btn-primary" type="button" @click="calculateFood">Go</button>
	                		</div>

	                	</div>
                	</h1>
            	</div>
        	</div>
        	<div class="row">
            	<div class="col resource">
               		<h1 class="resource-amount">
               			<div v-if="!editMoney" @click="editMoney = !editMoney">
                    		<span class="dollar-sign">$</span> {{ team.money }}
                    	</div>
                    	<div class="input-group" v-else>

	                		<input class="form-control" v-model="money" type="text" @keyup.enter="calculateMoney"> 

	                		<div class="input-group-append">
	                			<button class="btn btn-primary" type="button" @click="calculateMoney">Go</button>
	                		</div>

	                	</div>
                	</h1>
            	</div>
        	</div>
        </div>
	</div>
</template>

<script>
	export default {
		props: ['team'],
		data() {
			return {
				resources: '',
	    		canInput: false,
	    		editMoney: false,
	    		editFood: false,
	    		editWater: false,
	    		food: 0,
	    		money: 0,
	    		water: 0
			};
		},
		methods: {
	    	calculate() {
	    		this.$emit('update', {resources: this.resources, team: this.team.id});
	    		this.canInput = false;
	    		this.resources = '';
	    	},

	    	input() {
	    		this.canInput = true;
	    	},

	    	calculateFood() {
	    		this.$emit('food', {amount: this.food, team: this.team.id});
	    		this.editFood = false;
	    		this.food = 0;
	    	},

	    	calculateMoney() {
	    		this.$emit('money', {amount: this.money, team: this.team.id});
	    		this.editMoney = false;
	    		this.money = 0;
	    	},

	    	calculateWater() {
	    		this.$emit('water', {amount: this.water, team: this.team.id});
	    		this.editWater = false;
	    		this.water = 0;
	    	}
	    },

	    computed: {
	    	foodAmountStyle() {
	    		var color = 'black';

	    		if(this.team.food < 10)
	    			color = "red";
	    		else if(this.team.food < 30)
	    			color = "black";

	    		return {
	    			color: color
	    		}
	    	},

	    	waterAmountStyle() {
	    		var color = 'black';

	    		if(this.team.water < 10)
	    			color = "red";
	    		else if(this.team.water < 30)
	    			color = "black";
	    		return {
	    			color: color
	    		}
	    	}
	    }	
	}
</script>