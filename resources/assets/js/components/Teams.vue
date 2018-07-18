<template>
	<div>
		<div class="row teams">
			<div class="col p-0 team d-flex justify-content-center" v-for="team in teams" v-if="team.id <= 5">
	        	<team :team="team" @update="update" @food="calcFood" @water="calcWater" @money="calcMoney"></team>
	        </div>
	    </div>
		<div class="row">
			<div class="col text-center timer d d-flex align-items-center justify-content-center align-items-center">
				
				<timer @reduce="reduce"></timer>
			</div>
		</div>
		<div class="row teams">
			<div class="col p-0 team d-flex justify-content-center" v-for="team in teams" v-if="team.id > 5">
		    	<team :team="team" @update="update" @food="calcFood" @water="calcWater" @money="calcMoney"></team>
	        </div>
	    </div>
	</div>
</template>

<script>
	export default {
		props: [''],
		data() {
			return {
				teams:[]
			};
		},

		mounted() {
			this.getTeams();
			window.Echo.channel('teams')
				.listen('TeamResourceUpdated', event => this.getTeams());
		},

		methods: {
			getTeams() {
				axios.get("/teams")
					.then(response => this.setTeams(response));
			},

			setTeams(response) {
				this.teams = response.data;
			},

			update(data){
				var numbers = data.resources.split(";");
				// console.log(data.team - 1);
				this.teams[data.team - 1].water = numbers[0];
				this.teams[data.team - 1].food = numbers[1];
				this.teams[data.team - 1].money = numbers[2];
			},

			reduce(data) {
				// console.log("reducing");
				this.teams.forEach(function(team){
					team.water -= 10;
					team.food -= 10;
				});

				axios.post("/teams/reduce");
			},

			calcFood(data) {
				this.teams[data.team - 1].food += parseInt(data.amount);
			},

			calcMoney(data) {
				this.teams[data.team - 1].money += parseInt(data.amount);
			},

			calcWater(data) {
				// console.log("calc water");
				this.teams[data.team - 1].water += parseInt(data.amount);
			}
		}		
	}
</script>