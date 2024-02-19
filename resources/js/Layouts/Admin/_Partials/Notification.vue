<template>
	<li class="mx-3 nav-item dropdown d-flex align-items-center">
		<a id="dropdownMenuButton" href="#" class="p-0 nav-link text-white toggle-button" data-bs-toggle="dropdown"
			aria-expanded="false" @click="showNotificationMenu = !showNotificationMenu">
			<i class="cursor-pointer fa fa-bell"></i>
		</a>
		<ul class="px-2 py-3 dropdown-menu dropdown-menu-end me-sm-n4" :class="showNotificationMenu ? 'show' : ''"
			aria-labelledby="dropdownMenuButton" @click="showNotificationMenu = false">
			<li class="mb-2">
				<a class="dropdown-item border-radius-md" href="javascript:;">
					<div class="py-1 d-flex">
						<div class="my-auto">
							<img src="@/assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user image" />
						</div>
						<div class="d-flex flex-column justify-content-center">
							<h6 class="mb-1 text-sm font-weight-normal">
								<span class="font-weight-bold">New message</span> from
								Laur
							</h6>
							<p class="mb-0 text-xs text-secondary">
								<i class="fa fa-clock me-1"></i>
								13 minutes ago
							</p>
						</div>
					</div>
				</a>
			</li>
			<li class="mb-2">
				<a class="dropdown-item border-radius-md" href="javascript:;">
					<div class="py-1 d-flex">
						<div class="my-auto">
							<img src="@/assets/img/small-logos/logo-spotify.svg"
								class="avatar avatar-sm bg-gradient-dark me-3" alt="logo spotify" />
						</div>
						<div class="d-flex flex-column justify-content-center">
							<h6 class="mb-1 text-sm font-weight-normal">
								<span class="font-weight-bold">New album</span> by
								Travis Scott
							</h6>
							<p class="mb-0 text-xs text-secondary">
								<i class="fa fa-clock me-1"></i>
								1 day
							</p>
						</div>
					</div>
				</a>
			</li>
			<li>
				<a class="dropdown-item border-radius-md" href="javascript:;">
					<div class="py-1 d-flex">
						<div class="my-auto">
							<i class="fa fa-clock avatar avatar-sm bg-gradient-secondary me-3"></i>
						</div>
						<div class="d-flex flex-column justify-content-center">
							<h6 class="mb-1 text-sm font-weight-normal">
								Payment successfully completed
							</h6>
							<p class="mb-0 text-xs text-secondary">
								<i class="fa fa-clock me-1"></i>
								2 days
							</p>
						</div>
					</div>
				</a>
			</li>
		</ul>
	</li>
</template>

<script setup>
import { ref, watch } from 'vue';

const showNotificationMenu = ref(false)

const hideNotificationMenu = (event) => {
	const notificationMenu = document.querySelector('.dropdown-menu');
	const button = document.querySelector('.toggle-button')

	if (!notificationMenu.contains(event.target) && !button.contains(event.target)) {
		showNotificationMenu.value = !showNotificationMenu.value;
	}
};

watch(
	() => showNotificationMenu.value,
	(showNotificationMenu, prevshowNotificationMenu) => {
		if (showNotificationMenu) {
			document.addEventListener('click', hideNotificationMenu, true);
		} else {
			document.removeEventListener('click', hideNotificationMenu, true);
		}
	}
)
</script>