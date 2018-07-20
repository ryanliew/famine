<template>
	<div @click="$emit('pause')">
		<div class="timer-background" :style="progressBarStyle"></div>
		<span :style="timerTextStyle">{{ hours | two_digits }}:{{ minutes | two_digits }}:{{ seconds | two_digits }}</span>
	</div>
</template>

<script>
export default {
	props: ['isPaused', 'duration'],
	data() {
		return {
			now: Math.trunc((new Date()).getTime() / 1000),
			time: 0,
			actualduration: 0,
			ongoingTimer: ''
		};
	},

	computed: {
		progressBarStyle() {
			var background = "orange";

			// if(this.percentage < 10) {
			// 	background = "#f87b66";
			// }
			// else if(this.percentage <= 50) {
			// 	background = "#f8f166";
			// }

			return {
				width: this.percentage + "%",
				background: background
			}
		},

		timerTextStyle() {
			var color = "black";

			// if(this.percentage < 10) {
			// 	color = "red";
			// }
			// else if(this.percentage <= 50) {
			// 	color = "#6e6907";
			// }

			return {
				color: color
			}
		},

		max() {
			return this.actualduration * 60;
		},

		percentage() {
			return this.progress / this.max * 100;
		},

		progress() {
			return this.time - this.now;
		},

		seconds() {
			return (this.progress) % 60;
		},

		minutes() {
			return Math.trunc((this.progress) / 60) % 60;
		},

		hours() {
			return Math.trunc(this.progress / 60 / 60) % 24;
		}
	},

	methods: {
		start() {
			this.actualduration = this.duration;
			this.time = this.actualduration * 60 + this.now;
			this.ongoingTimer = window.setInterval(() => {
				this.now = Math.trunc((new Date()).getTime() / 1000);
				if(this.isPaused)
					this.time += 1;

				if(this.now == this.time) {
					this.time = this.duration * 60 + this.now;
					this.$emit("open");
					this.stop();
				}
			}, 1000);
		},

		stop() {
			clearInterval(this.ongoingTimer);
		}
	},

	mounted() {
		this.start();
	},

	filters: {
		two_digits: function (value) {
			if(value.toString().length <= 1)
			{
				return "0" + value.toString();
			}
			return value.toString();
		}
	}	
}
</script>