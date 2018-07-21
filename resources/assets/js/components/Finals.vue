<template>
	<div>
		<div class="full-height" v-if="!failed">
			<div class="hungerSection">
				<hungry-meter :current="current_hunger" @start="toggleStatus" @edited="editHunger"></hungry-meter>
			</div>

			<div class="evaluation" :class="result" :style="'background-image: url(/img/' + selected_tree + '.png)'" v-if="evaluating"></div>
			<div v-show="!evaluating" class="final-game">

				<div class="full-height d-flex flex-column justify-content-center align-items-center game3-selectors">

					<h1>机会： {{ remaining_chance }}</h1>
					<div class="d-flex justify-content-center align-items-center">
						<div class="sector text-center" @click="showSelector(1)" :class="sectorClass1">
							<div>
								<p>1</p>
								<div class="selected-img" v-if="answer1" :style="'background-image: url(/img/' + answer1 + '.png)'"></div>
							</div>
						</div>
						<div class="sector text-center" @click="showSelector(2)" :class="sectorClass2">
							<div>
								<p>2</p>
								<div class="selected-img" v-if="answer2" :style="'background-image: url(/img/' + answer2 + '.png)'"></div>
							</div>
						</div>
						<div class="sector text-center" @click="showSelector(3)" :class="sectorClass3">
							<div>
								<p>3</p>
								<div class="selected-img" v-if="answer3" :style="'background-image: url(/img/' + answer3 + '.png)'"></div>
							</div>
						</div>
						<div class="sector text-center" @click="showSelector(4)" :class="sectorClass4">
							<div>
								<p>4</p>
								<div class="selected-img" v-if="answer4" :style="'background-image: url(/img/' + answer4 + '.png)'"></div>
							</div>
						</div>
						<div class="sector text-center" @click="showSelector(5)" :class="sectorClass5">
							<div>
								<p>5</p>
								<div class="selected-img" v-if="answer5" :style="'background-image: url(/img/' + answer5 + '.png)'"></div>
							</div>
						</div>
					</div>
				</div>


				<div class="timer" @click="spacePaused = !spacePaused">
					<div class="space-indicator">
						<span v-text="spaceIndicator" :class="spaceIndicatorClass"></span>
					</div>
					<space-timer ref="timer" :isPaused="spacePaused" :duration="duration" @open="openSpace"></space-timer>
					<div style="display:none">
						<space-timer ref="hungerTimer" :isPaused="hungerPaused" :duration="5" @open="addHunger"></space-timer>
					</div>
				</div>
				<answer-selector :active="selecting" @input="putAnswer" @close="close"></answer-selector>
			</div>
		</div>
		<div class="full-height d-flex justify-content-center align-items-center" v-else>
			<img src="/img/failed.jpg">
		</div>
	</div>
</template>

<script>
	import AnswerSelector from "./FinalAnswerSelector";
	import SpaceTimer from "./SpaceOpenTimer";
	import HungryMeter from "./HungryMeter";

	export default {
		props: ['game'],

		components: { AnswerSelector, SpaceTimer, HungryMeter },

		data() {
			return {
			 	answer1: '',
			 	answer2: '',
			 	answer3: '',
			 	answer4: '',
			 	answer5: '',
			 	selecting: false,
			 	current: '',
			 	evaluating: false,
			 	selected_tree: '',
			 	result: '',
			 	duration: 15,
			 	open: false,
			 	spacePaused: true,
			 	hungerPaused: true,
			 	current_hunger: this.game.hungry_count,
			 	timing: false,
			 	timeout: '',
			 	remaining_chance: this.game.flag_timer,
			 	failed: false
			};
		},

		methods: {
			showSelector(number) {
				this.selecting = true;
				this.current = number;
			},

			putAnswer(e) {

				if (e.data == 'water_tree' || e.data == 'mangosteen' || e.data == 'rainbow' || e.data == 'maple' || e.data == 'starfish' || e.data == 'apple') this.selected_tree = e.data;

				switch(this.current) {
					case 1: 
						this.answer1 = e.data;
						break;
					case 2: 
						this.answer2 = e.data;
						break;
					case 3: 
						this.answer3 = e.data;
						break;
					case 4: 
						this.answer4 = e.data;
						break;
					case 5: 
						this.answer5 = e.data;
						break;
				}
				this.close();
			},

			close() {
				this.selecting = false;
				this.current = '';
			},

			evaluateAnswer() {
				if(!this.timing) {
					
					this.timeout = window.setTimeout(() => {
						this.answer1 = false;
						this.answer2 = false;
						this.answer3 = false;
						this.answer4 = false;
						this.answer5 = false;
						this.timing = true;
						this.remaining_chance -= 1;
						this.persistTry();
					}, 180000);

				}

				if(this.answer1 && this.answer2 && this.answer3 && this.answer4 && this.answer5) {
					clearTimeout(this.timeout);

					this.evaluating = true;
					this.result = 'fail';
					if(this.answer1 == 'water_tree' 
						&& this.answer2 == 'black' 
						&& this.is_nutrient(this.answer3)
						&& this.answer4 == 'fall' 
						&& this.answer5 == 'west')
					{
						this.result = 'success';
					}

					window.setTimeout(() => { 
						if(this.result == 'fail'){
							this.evaluating = false;
							this.answer1 = false;
							this.answer2 = false;
							this.answer3 = false;
							this.answer4 = false;
							this.answer5 = false;
							this.remaining_chance -= 1; 
							this.persistTry();
						}
					}, 6000);
				}
			},

			is_nutrient(value) {
				return value == "calcium" || value == "iron" || value == "magnesium" || value == "potassium"  || value == "phosphorus" || value == "nitrogen"; 
			},

			openSpace() {
				this.duration = this.open ? 15 : 3;
				this.open = !this.open;
				Vue.nextTick( () => this.$refs.timer.start() );
			},

			addHunger() {
				this.current_hunger = parseInt(this.current_hunger) + 2;
				Vue.nextTick( () => this.$refs.hungerTimer.start());

				this.persistHunger();
			},

			editHunger(e) {
				this.current_hunger = e.hunger;
				axios.post("/game3/edit", {hunger: this.current_hunger});
			},

			persistHunger() {
				axios.post("/game3")
					.catch(error => this.persistHunger());
			},

			persistTry() {
				axios.post("/game3/try")
					.catch(error => this.persistTry());

				if(this.remaining_chance == 0) {
					this.current_hunger = 50;
				}
			},

			toggleStatus() {
				this.hungerPaused ? this.start() : this.pause();
			},

			start() {
				this.hungerPaused = false;
				this.spacePaused = false;
			},

			pause() {
				this.hungerPaused = true;
				this.spacePaused = true;
			}
		},

		computed: {
			sectorClass1() {
				return this.answer1 ? 'has-answer' : '';
			},

			sectorClass2() {
				return this.answer2 ? 'has-answer' : '';
			},

			sectorClass3() {
				return this.answer3 ? 'has-answer' : '';
			},

			sectorClass4() {
				return this.answer4 ? 'has-answer' : '';
			},

			sectorClass5() {
				return this.answer5 ? 'has-answer' : '';
			},

			spaceIndicator() {
				return this.open ? '空间开放' : '空间关闭';
			},

			spaceIndicatorClass() {
				return this.open ? 'background-green' : 'background-red';
			}
		},

		watch: {
			answer1(newVal, oldVal) {
				if(newVal) this.evaluateAnswer();
			},

			answer2(newVal, oldVal) {
				if(newVal) this.evaluateAnswer();
			},

			answer3(newVal, oldVal) {
				if(newVal) this.evaluateAnswer();
			},

			answer4(newVal, oldVal) {
				if(newVal) this.evaluateAnswer();
			},

			answer5(newVal, oldVal) {
				if(newVal) this.evaluateAnswer();
			},

			current_hunger(newVal, oldVal) {
				if(newVal == 50) this.failed = true;
			}
		}	
	}
</script>