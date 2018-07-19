<template>
	<div class="image-selector" v-if="active">
		<div class="close-button text-danger" @click="$emit('close')"><i class="fas fa-times fa-2x"></i></div>
		<div class="d-flex flex-wrap">
			<div class="selector-image" v-for="(option, index) in options" @click="enter(option)" :style="'background-image: url(/img/' + option + '.png)'">

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['active'],
		data() {
			return {
				options: [
			 		'water_tree', 'mangosteen', 'rainbow', 'maple', 'starfish', 'apple', 'north', 'south', 'east', 'west','center', 'calcium', 'iron', 'magnesium', 'potassium', 'phosphorus', 'nitrogen', 'wedding', 'seed', 'cut', 'fall', 'spore', 'black', 'gray', 'mud', 'sand', 'volcano', 'red'
			 	]
			};
		},

		methods: {
			enter(option) {
				this.$emit('input', {data: option});
			}
		}	
	}
</script>