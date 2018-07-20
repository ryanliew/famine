<template>
	<div>
		<div class="d-flex hungry-meter p-2">
			<h1 @click="editing = true" v-if="!editing">{{ current }} / 50</h1>
			<input type="number" v-model="edit_hunger" @keyup.enter="submitHunger" v-if="editing">
			<div class="flex-grow-1 hungry-meter-bar" @click="$emit('start')">
				<div :style="'width:' + this.percentage + '%;'" class="timer-background"></div>
			</div>
		</div>
		<div class="btn btn-primary" @click="activate" v-if="!showing">蓝环启动</div>
		<div v-if="showing">
			<div v-if="showing_instructions" class="color-instructions" :style="'background-color:' + sets[current_set][current_group] +';'"></div>
			<div class="blue-band-timer timer">
				<blue-band-timer ref="blueband" v-if="showing_timer" :duration="6" @open="stopTimer"></blue-band-timer>
			</div>
		</div>
	</div>
</template>

<script>
	import BlueBandTimer from "./SpaceOpenTimer";

	export default {
		props: ['current'],

		components: { BlueBandTimer },

		data() {
			return {
				sets: [
					['red', 'yellow', 'green', 'blue', 'black', 'green', 'blue', 'black', 'red', 'yellow'],
					['yellow', 'green', 'blue', 'black', 'red', 'blue', 'black', 'red', 'yellow', 'green'],
					['green', 'blue', 'black', 'red', 'yellow', 'black', 'red', 'yellow', 'green', 'blue'],
					['blue', 'black', 'red', 'yellow', 'green', 'red', 'yellow', 'green', 'blue', 'black'],
					['black', 'red', 'yellow', 'green', 'blue', 'yellow', 'green', 'blue', 'black', 'red'],
				],
				current_set: 0,
				current_group: 0,
				showing: false,
				ongoing: '',
				showing_instructions: false,
				showing_timer: false,
				edit_hunger: '',
				editing: false
			};
		},

		methods: {
			activate() {
				this.showing = true;

				this.showing_instructions = true;
				this.showing_timer = false;

				this.ongoing = window.setInterval(() => {
					this.current_group += 1;

					if(this.current_group == 10)
					{
						window.clearInterval(this.ongoing);
						this.current_set += 1;
						this.current_group = 0;
						this.startTimer();
					}
				}, 3000);
			},

			startTimer() {
				this.showing_instructions = false;
				this.showing_timer = true;

				this.$refs.blueband.start();
			},

			stopTimer() {
				this.showing_timer = false;
				this.showing = false;
			},

			submitHunger() {
				this.$emit("edited", {hunger: this.edit_hunger});
				this.editing = false;
			}
		},

		computed: {
			percentage() {
				return this.current / 50 * 100;
			},


		}	
	}
</script>