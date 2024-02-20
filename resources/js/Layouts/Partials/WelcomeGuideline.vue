<template>
	<div class="background-overlay">
		<div class="min-vh-100 d-flex justify-content-center align-items-center">
			<div class="container-fluid carousel-container">
				<carousel ref="welcomeCarousel" @slide-end="handleSlideEnd" @slide-start="handleSlideStart"
					:items-to-show="1" class="m-auto">
					<Slide v-for="image in carousel_images" :key="image.id">
						<div class="d-flex flex-column px-5">
							<h1 class="carousel-number">0{{ image.id }}</h1>
							<h3 class="carousel-description">{{ image.description }}</h3>
							<div class="position-relative">
								<img v-if="currentSlideEnd === 2" class="carousel-arrow d-none d-sm-block"
									:src="images.arrow" alt="arrow">
								<img class="carousel-image" :src="image.src" :alt="image.alt">
							</div>
						</div>
					</Slide>
					<template #addons>
						<Navigation />
						<Pagination />
					</template>
				</carousel>
				<div class="text-center my-4" v-show="currentSlideStart === 4">
					<form @submit.prevent="submit">
						<argon-button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
							Invest Now
						</argon-button>
					</form>
				</div>
			</div>

			<!-- Confetti -->
			<div v-show="currentSlideStart === 4" class="confetti">
				<img class="top-left-corner" style="bottom: 10vh; right: 40vw; rotate: 300deg; scale: 0.7;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="top-left-corner" style="bottom: 5vh; right: 35vw; rotate: 90deg; scale: 0.3;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" style="bottom: 0vh; right: 33vw; rotate: 90deg; scale: 0.5;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" style="bottom: 12vh; right: 30vw; rotate: 45deg; scale: 0.3;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" :src="images.purpleConfetti" alt="purple confetti">
				<img class="top-left-corner" style="bottom: 22vh; right: 23vw; rotate: 70deg; scale: 0.3;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" style="bottom: 20vh; right: 19vw; rotate: 0deg; scale: 0.3;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" style="bottom: 15vh; right: 15vw;" :src="images.orangeConfettiExtraSmall"
					alt="orange confetti">
				<img class="top-left-corner" style="bottom: 35vh; right: 15vw; rotate: 30deg; scale: 0.7;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-left-corner" style="bottom: 30vh; right: 10vw;" :src="images.redRectangleConfetti"
					alt="red confetti">
				<img class="top-left-corner" style="bottom: 17vh; right: 10vw; rotate: 10deg; scale: 0.6;"
					:src="images.orangeRectangleConfetti" alt="orange confetti">
				<img class="top-left-corner"
					style="bottom: 40vh; right: 8vw; rotate: 70deg; scale: 0.6; filter: brightness(80%);"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="top-left-corner" style="bottom: 30vh; right: 5vw; rotate: 0deg; scale: 0.5; "
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-left-corner" style="top: 10vh; right: 40vw; rotate: -30deg; scale: 0.8;"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-left-corner" style="top: 20vh; right: 30vw; rotate: 0deg; scale: 0.8;"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-left-corner" :src="images.blueConfetti" alt="blue confetti">
				<img class="bottom-left-corner" style="top: 40vh; right: 20vw; rotate: 90deg; scale: 0.8;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="bottom-left-corner" style="top: 25vh; right: 15vw; rotate: -30deg; scale: 0.8;"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-left-corner" style="top: 35vh; right: 10vw; rotate: 90deg; scale: 0.7;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="bottom-left-corner" style="top: 20vh; right: 2vw;" :src="images.purpleConfettiSmall"
					alt="purple confetti">
				<img class="top-right-corner"
					style="bottom: 35vh; left: 5vw; rotate: 90deg; scale: 0.3; filter: brightness(80%);"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-right-corner" style="bottom: 17vh; left: 7vw; rotate: 90deg; scale: 1.5;"
					:src="images.lightBlueRectangleConfetti" alt="light blue confetti">
				<img class="top-right-corner" style="bottom: 16vh; left: 15vw;" :src="images.redConfetti"
					alt="red confetti">
				<img class="top-right-corner" style="bottom: 20vh; left: 18vw; rotate: 180deg; scale: 0.5;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="top-right-corner" style="bottom: 40vh; left: 23vw; rotate: 90deg; scale: 0.5;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="top-right-corner" style="bottom: 18vh; left: 20vw;" :src="images.purpleConfettiExtraSmall"
					alt="purple confetti">
				<img class="top-right-corner" style="bottom: 20vh; left: 25vw; rotate: 0deg; scale: 0.8;"
					:src="images.lightBlueRectangleConfetti" alt="light blue confetti">
				<img class="top-right-corner" style="bottom: 42vh; left: 35vw; rotate: 270deg; scale: 0.8;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="top-right-corner" style="bottom: 30vh; left: 40vw; rotate: 90deg; scale: 0.8;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="top-right-corner" :src="images.blueConfettiSmall" alt="blue confetti">
				<img class="top-right-corner" style="bottom: 8vh; left: 30vw; rotate: 45deg; scale: 0.5;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-right-corner" style="bottom: 2vh; left: 40vw; rotate: 270deg; scale: 0.6;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="top-right-corner" style="bottom: 10vh; left: 40vw; rotate: 270deg; scale: 0.6;"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-right-corner" style="top: 25vh; left: 5vw; rotate: 30deg; scale: 1;"
					:src="images.orangeRectangleConfetti" alt="orange confetti">
				<img class="bottom-right-corner" style="top: 35vh; left: 10vw; rotate: 90deg; scale: 0.8;"
					:src="images.greenRectangleConfetti" alt="green confetti">
				<img class="bottom-right-corner" style="top: 20vh; left: 5vw;" :src="images.blueConfettiExtraSmall"
					alt="blue confetti">
				<img class="bottom-right-corner" :src="images.orangeConfetti" alt="orange confetti">
				<img class="bottom-right-corner" style="top: 20vh; left: 28vw; rotate: 90deg; scale: 0.9;"
					:src="images.darkBlueRectangleConfetti" alt="dark blue confetti">
				<img class="bottom-right-corner" style="top: 5vh; left: 30vw; rotate: 150deg; scale: 0.8;"
					:src="images.yellowRectangleConfetti" alt="yellow confetti">
				<img class="bottom-right-corner" style="top: 15vh; left: 40vw; rotate: 270deg; scale: 0.5;"
					:src="images.redRectangleConfetti" alt="red confetti">
				<img class="bottom-right-corner" style="top: 3vh; left: 42vw; rotate: 0deg; scale: 0.8;"
					:src="images.yellowRectangleConfetti" alt="yellow confetti">
			</div>
		</div>
	</div>
</template>

<script setup>
import { reactive, ref, onMounted, onUnmounted } from "vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";
import images from '@/assets/img/welcome';
import { useForm } from '@inertiajs/vue3';
import ArgonButton from "@/Components/ArgonButton.vue";

const welcomeCarousel = ref(null);
const currentSlideEnd = ref()
const currentSlideStart = ref()

const handleSlideEnd = (data) => {
	currentSlideEnd.value = data.currentSlideIndex
}

const handleSlideStart = (data) => {
	currentSlideStart.value = data.slidingToIndex
}

const handleArrowKey = (event) => {
	const carouselInstance = welcomeCarousel.value;
	if (event.key === "ArrowLeft") {
		carouselInstance.prev();
	} else if (event.key === "ArrowRight") {
		carouselInstance.next();
	}
};

onMounted(() => {
	window.addEventListener('keydown', handleArrowKey);
});

onUnmounted(() => {
	window.removeEventListener('keydown', handleArrowKey);
});

const carousel_images = reactive([
	{
		id: 1,
		description: 'Go to "Traders (Copy Trading)" to check all trader\'s performances',
		src: images.welcome1,
		alt: "Step 1",
	},
	{
		id: 2,
		description: 'Go to "Wallet" to deposit & check on-going investments.',
		src: images.welcome2,
		alt: "Step 2",
	},
	{
		id: 3,
		description: 'Trigger Live/Demo at the upper right corner.',
		src: images.welcome3,
		alt: "Step 3",
	},
	{
		id: 4,
		description: 'Start investing after choosing a trader.',
		src: images.welcome4,
		alt: "Step 4",
	},
	{
		id: 5,
		description: 'Close investment account after profiting.',
		src: images.welcome5,
		alt: "Step 5",
	},
]);

const form = useForm();

const submit = () => {
	form.put(route('dashboard.update'));
};

</script>

<style scoped>
.background-overlay {
	position: fixed;
	background-color: rgba(180, 180, 180, 0.3);
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	z-index: 1;
	overflow: auto;
}

.carousel-container {
	padding: 0 20vw;
}

@media only screen and (max-width: 1200px) {
	.carousel-container {
		padding: 0;
	}
}

.carousel-number {
	/* font-size: 128px; */
	font-size: clamp(1rem, min(10vh, 128px), 128px);
	font-weight: 800;
	color: rgba(23, 43, 77, 0.2);
}

.carousel-description {
	font-size: clamp(1rem, min(3.5vh, 2rem), 2rem);
	max-width: 500px;
	margin: auto;
}

.carousel-image {
	object-fit: contain;
	height: 100%;
	width: 100%;
}

.carousel-arrow {
	position: absolute;
	top: -20px;
	right: 8vw;
	width: min(6vw, 165px);
}

/* overwrite plugin */
.carousel__pagination {
	padding-right: 34px;
}

.confetti {
	position: absolute;
	z-index: -1;
}

.confetti img {
	position: absolute;
	opacity: 1;
	transform: scale(1);
	animation-duration: 0.8s;
	animation-fill-mode: normal;
	/* animation-timing-function: ease-in-out; */
}

.top-left-corner {
	bottom: 7vh;
	right: 10vw;
	animation-name: slide-out-to-top-left-corner;
}

.bottom-left-corner {
	top: 20vh;
	right: 15vw;
	animation-name: slide-out-to-bottom-left-corner;
}

.top-right-corner {
	bottom: 5vh;
	left: 20vw;
	animation-name: slide-out-to-top-right-corner;
}

.bottom-right-corner {
	top: 10vh;
	left: 10vw;
	animation-name: slide-out-to-bottom-right-corner;
}

@keyframes slide-out-to-top-left-corner {
	from {
		bottom: 0vh;
		right: 0vw;
		opacity: 0.5;
		transform: scale(0.5);
	}
}

@keyframes slide-out-to-bottom-left-corner {
	from {
		top: 0vh;
		right: 0vw;
		opacity: 0.5;
		transform: scale(0.5);
	}
}

@keyframes slide-out-to-top-right-corner {
	from {
		bottom: 0vh;
		left: 0vw;
		opacity: 0.5;
		transform: scale(0.5);
	}
}

@keyframes slide-out-to-bottom-right-corner {
	from {
		top: 0vh;
		left: 0vw;
		opacity: 0.5;
		transform: scale(0.5);
	}
}
</style>