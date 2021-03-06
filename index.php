<?php
// Initialize the session
session_start(); 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Time Management</title>
		<script src="https://unpkg.com/vue"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style>
			body {
				background-color: #d0e3e8;
			}
			.date {
				color: green;
				font-family: Tahoma, Geneva, sans-serif;
			}
			.flexcontainer {
				display: flex;
				flex-direction: column;
				align-items: center;
			}
			.app {
				background-color: white;
				width: 500px;
				border-radius: 20px
			}
			.header {
				align-items: center;
				color: green;
				text-align: center;
				font-family: "Lucida Console", Monaco, monospace;
				letter-spacing: 2px;
			}
			.eventType, .rNewEvent {
				display: flex;
				justify-content: center;
				align-items: center;
			}
			.wrapper {
				display: flex;
				padding: 5px 20px;
				border-bottom: 1px solid black;
			}
			.center {
				display: flex;
				justify-content: center;
			}
			.rNewEvent, .fNewEvent, .dNewEvent {
				display: grid;
				grid-template-columns: 1fr;
				grid-gap: 16px;
				justify-content: center;
				align-items: center;
			}
			.schedule-item {
				display: grid;
				grid-template-columns: 1fr 1fr 1fr 1fr;
				grid-gap: 16px;
			}
			.topright {
			    position: absolute;
			    right: 20px;
			    top: 20px;
			}
		</style>
	</head>
	<body>
		<div class="topright">
			<a href="logout.php">Logout</a>
		</div>
		<div class="header">
			<h1>TIME MANAGEMENT</h1>
		</div>
		<div class=flexcontainer>
			<div class="app" id="app">
				<p></p>
				<div class="center">
					<button @click="goBack()"><</button>
					<div class="date">&nbsp;&nbsp;{{ this.dateText }}&nbsp;&nbsp;</div>
					<button @click="goForward()">></button>
				</div>
				<p></p>
				<div class="center">
					<div class="schedule-item">
						<template v-for="item in todaysEvents">
							<div>{{ item.startTime }}</div>
							<div>{{ item.endTime }}</div>
							<div>{{ item.desc }}</div>
							<button @click="remove_item(item.itemID)">Delete</button>
						</template>
					</div>
				</div>
				<p></p>
				<div class="eventType">
					<select v-model="priority">
						<option disabled value="">Please select one</option>
						<option>Required Time</option>
						<option>Flexible</option>
						<option>Due Date</option>
					</select>
				</div>
				<p></p>
				<div class="rNewEvent" v-if="priority == 'Required Time'">
					<div class="wrapper">
						<div>Description: &nbsp;</div>
						<input v-model="describe" placeholder="Description">
					</div>
					<div class="wrapper">
						<div>Start Time: &nbsp;</div>
						<select v-model="startHour">
							<option disabled value=""></option>
								<template v-for="n in 12">
									<option>{{ n }}</option>
								</template>
						</select>
						<div>&nbsp;:&nbsp;</div>
						<select v-model="startMin">
							<option disabled value=""></option>
							<template v-for="n in 60">
								<template v-if="n < 11">
									<option>{{ '0' + (n - 1) }}</option>
								</template>
								<template v-else>
									<option>{{ (n - 1) }}</option>
								</template>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="startMOA">
							<option disabled value=""></option>
							<option>AM</option>
							<option>PM</option>
						</select>
					</div>
					<div class="wrapper">
						<div>Start Date: &nbsp;</div>
						<select v-model="startMonth">
							<option disabled value=""></option>
							<template v-for="item in months">
								<option>{{ item.name }}</option>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="startDay">
							<option disabled value=""></option>
							<template v-for="item in months">
								<template v-if="item.name == startMonth">
									<template v-for="n in item.days">
										<option>{{ n }}</option>
									</template>
								</template>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="startYear">
							<option disabled value=""></option>
							<template v-for="n in 10">
								<option>{{ date.getFullYear() + (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="wrapper">
						<div>End Time: &nbsp;</div>
						<select v-model="endHour">
							<option disabled value=""></option>
								<template v-for="n in 12">
									<option>{{ n }}</option>
								</template>
						</select>
						<div>&nbsp;:&nbsp;</div>
						<select v-model="endMin">
							<option disabled value=""></option>
							<template v-for="n in 60">
								<template v-if="n < 11">
									<option>{{ '0' + (n - 1) }}</option>
								</template>
								<template v-else>
									<option>{{ (n - 1) }}</option>
								</template>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="endMOA">
							<option disabled value=""></option>
							<option>AM</option>
							<option>PM</option>
						</select>
					</div>
					<div class="wrapper">
						<div>End Date: &nbsp;</div>
						<select v-model="endMonth">
							<option disabled value=""></option>
							<template v-for="item in months">
								<option>{{ item.name }}</option>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="endDay">
							<option disabled value=""></option>
							<template v-for="item in months">
								<template v-if="item.name == endMonth">
									<template v-for="n in item.days">
										<option>{{ n }}</option>
									</template>
								</template>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="endYear">
							<option disabled value=""></option>
							<template v-for="n in 10">
								<option>{{ date.getFullYear() + (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="center">
						<button v-on:click="add_req()">Submit</button>
					</div>
				</div>
				<div class="fNewEvent" v-if="priority == 'Flexible'">
					<div class="wrapper">
						<div>Description: &nbsp;</div>
						<input v-model="describe" placeholder="Description">
					</div>
					<div class="wrapper">
						<div>Hours: &nbsp;</div>
						<select v-model="hours">
							<template v-for="n in 13">
								<option>{{ (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="wrapper">
						<div>Minutes: &nbsp;</div>
						<select v-model="minutes">
							<template v-for="n in 60">
								<option>{{ (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="center">
						<button v-on:click="add_flex()">Submit</button>
					</div>
				</div>
				<div class="dNewEvent" v-if="priority == 'Due Date'">
					<div class="wrapper">
						<div>Description: &nbsp;</div>
						<input v-model="describe" placeholder="Description">
					</div>
					<div class="wrapper">
						<div>Due Date: &nbsp;</div>
						<select v-model="dueMonth">
							<option disabled value=""></option>
							<template v-for="item in months">
								<option>{{ item.name }}</option>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="dueDay">
							<option disabled value=""></option>
							<template v-for="item in months">
								<template v-if="item.name == dueMonth">
									<template v-for="n in item.days">
										<option>{{ n }}</option>
									</template>
								</template>
							</template>
						</select>
						<div>&nbsp;</div>
						<select v-model="dueYear">
							<option disabled value=""></option>
							<template v-for="n in 10">
								<option>{{ date.getFullYear() + (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="wrapper">
						<div>Hours: &nbsp;</div>
						<select v-model="hours">
							<template v-for="n in 13">
								<option>{{ (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="wrapper">
						<div>Minutes: &nbsp;</div>
						<select v-model="minutes">
							<template v-for="n in 60">
								<option>{{ (n - 1) }}</option>
							</template>
						</select>
					</div>
					<div class="center">
						<button v-on:click="add_due()">Submit</button>
					</div>
				</div>
				<p></p>
			</div>
		</div>
	</body>
	<script>
		var app = new Vue({
			el: "#app",
			data: {
				describe: "",
				startHour: "",
				startMin: "",
				startMOA: "",
				endHour: "",
				endMin: "",
				endMOA: "",
				start: "",
				end: "",
				priority: "",
				eventsText: [],
				events: [],
				flexEvents: [],
				dueEvents: [],
				currentID: 0,
				dueId: "",
				startTime: "",
				endTime: "",
				minutes: "",
				hours: "",
				flex: [],
				startMonth: "",
				startDay: "",
				startYear: "",
				endMonth: "",
				endDay: "",
				endYear: "",
				dueMonth: "",
				dueDay: "",
				dueYear: "",
				dueDate: "",
				date: new Date(),
				currentDate: new Date(),
				dateText: "",
				todaysEvents: [],
				months: [
					{name: "January", days: 31, month: 0},
					{name: "February", days: 28, month: 1},
					{name: "March", days: 31, month: 2},
					{name: "April", days: 30, month: 3},
					{name: "May", days: 31, month: 4},
					{name: "June", days: 30, month: 5},
					{name: "July", days: 31, month: 6},
					{name: "August", days: 31, month: 7},
					{name: "September", days: 30, month: 8},
					{name: "October", days: 31, month: 9},
					{name: "November", days: 30, month: 10},
					{name: "December", days: 31, month: 11},
				],
				weekdays: [
					{name: "Sunday", id: 0},
					{name: "Monday", id: 1},
					{name: "Tuesday", id: 2},
					{name: "Wednesday", id: 3},
					{name: "Thursday", id: 4},
					{name: "Friday", id: 5},
					{name: "Saturday", id: 6},
				]
			},
			created: function(){
				var self = this;
				$.get("retrieve.php", function(data, status){
					events = JSON.parse(data);
					for (dataKey in events){
						var data = events[dataKey];
						var item = {
							itemID: data.itemID,
							startTime: new Date(parseInt(data.startTime)),
							endTime: new Date(parseInt(data.endTime)),
							desc: data.desc,
							itemType: data.itemType,
						}
						self.currentID = data.itemID;
						self.events.push(item);
						console.log(self.events[0]);
	    			}
    				if (self.events.length > 0){
    					self.listItems();
    				}
    				self.printDate();
				});
			},
			methods: {
				add_req: function(){
					for (monthKey in this.months){
						var month = this.months[monthKey];
						if (month.name == this.startMonth){
							this.startMonth = month.month;
						}
						if (month.name == this.endMonth){
							this.endMonth = month.month;
						}
					}
					if (this.startMOA == "PM" && this.startHour != 12){
						this.startHour = parseInt(this.startHour) + parseInt(12)
					} else if (this.startMOA == "AM" && this.startHour == 12){
						this.startHour = 0;
					}
					if (this.endMOA == "PM" && this.endHour != 12){
						this.endHour = parseInt(this.endHour) + parseInt(12)
					} else if (this.endMOA == "AM" && this.endHour == 12){
						this.endHour = 0;
					}
					day = new Date();
					this.start = new Date(this.startYear, this.startMonth, this.startDay, this.startHour, this.startMin);
					this.end = new Date(this.endYear, this.endMonth, this.endDay, this.endHour, this.endMin);
					var item = {
						itemID: this.currentID + 1,
						startTime: this.start,
						endTime: this.end,
						desc: this.describe,
						itemType: "r",
					}
					this.currentID += 1;
					this.events.push(item);
					this.pushEvent(item.itemID, item.startTime, item.endTime, item.desc, item.itemType);
					this.shuffleFlex();
					this.listItems();
				},
				add_flex: function(){
					var flexTime = {
						hours: this.hours,
						minutes: this.minutes,
						desc: this.describe,
					}
					this.flex.push(flexTime);
					this.sortFlex(this.hours, this.minutes, this.describe, "f");
					this.listItems();
				},
				add_due: function(){
					this.sortFlex(this.hours, this.minutes, this.describe, "d");
					for (monthKey in this.months){
						var month = this.months[monthKey];
						if (month.name == this.dueMonth){
							this.dueMonth = month.month;
						}
					}
					this.dueDate = new Date(this.dueYear, this.dueMonth, this.dueDay, 23, 59);
					for (eventKey in this.events){
						var event = this.events[eventKey];
						if (event.itemID == this.dueID){
							if (event.endTime.getTime() > this.dueDate.getTime()){
								this.events = this.events.filter((item) => { return item.itemType !== "f" });
								this.sortFlex(this.hours, this.minutes, this.describe, "d");
								this.shuffleFlex();
							} else {
								break;
							}
						}
					}
					this.listItems();
				},
				listItems: function(){
					this.events.sort(function(a, b) {
    					return a.startTime.getTime() - b.startTime.getTime();
					});
					this.autoRemoveItem();
					this.eventsText = [];
					for (eventKey in this.events){
						var event = this.events[eventKey];
						this.startTime = event.startTime;
						this.endTime = event.endTime;
						this.start = this.startTime + this.startTime.getTimezoneOffset();
						this.end = this.endTime + this.endTime.getTimezoneOffset();
						if (this.startTime.getHours() == 0){
							if (this.startTime.getMinutes() < 10){
								this.start = 12 + ":0" + this.startTime.getMinutes() + " AM"; 
							} else {
								this.start = 12 + ":" + this.startTime.getMinutes() + " AM"; 
							}
						} else if (this.startTime.getHours() > 12){
							if (this.startTime.getMinutes() < 10){
								this.start = (this.startTime.getHours() - 12)  + ":0" + this.startTime.getMinutes() + " PM";
							} else {
								this.start = (this.startTime.getHours() - 12)  + ":" + this.startTime.getMinutes() + " PM";
							}
						} else if (this.startTime.getHours() == 12){
							if (this.startTime.getMinutes() < 10){
								this.start = 12 + ":0" + this.startTime.getMinutes() + " PM";
							} else {
								this.start = 12 + ":" + this.startTime.getMinutes() + " PM";
							}
						} else {
							if (this.startTime.getMinutes() < 10){
								this.start = this.startTime.getHours() + ":0" + this.startTime.getMinutes() + " AM";
							} else {
								this.start = this.startTime.getHours() + ":" + this.startTime.getMinutes() + " AM";
							}
						}
						if (this.endTime.getHours() == 0){
							if (this.endTime.getMinutes() < 10){
								this.end = 12 + ":0" + this.endTime.getMinutes() + " AM"; 
							} else {
								this.end = 12 + ":" + this.endTime.getMinutes() + " AM"; 
							}
						} else if (this.endTime.getHours() > 12){
							if (this.endTime.getMinutes() < 10){
								this.end = (this.endTime.getHours() - 12)  + ":0" + this.endTime.getMinutes() + " PM";
							} else {
								this.end = (this.endTime.getHours() - 12)  + ":" + this.endTime.getMinutes() + " PM";
							}
						} else if (this.endTime.getHours() == 12){
							if (this.endTime.getMinutes() < 10){
								this.end = 12 + ":0" + this.endTime.getMinutes() + " PM";
							} else {
								this.end = 12 + ":" + this.endTime.getMinutes() + " PM";
							}
						} else {
							if (this.endTime.getMinutes() < 10){
								this.end = this.endTime.getHours() + ":0" + this.endTime.getMinutes() + " AM";
							} else {
								this.end = this.endTime.getHours() + ":" + this.endTime.getMinutes() + " AM";
							}
						}
						var item = {
							itemID: event.itemID,
							startTime: this.start,
							endTime: this.end,
							desc: event.desc,
							date: event.startTime,
							itemType: event.itemType,
						}
						this.eventsText.push(item);
						this.listByDate();
					}
				},
				sortFlex: function(hours, minutes, desc, identity){
					var timeInMillSec = (parseInt(minutes) + (parseInt(hours) * 60))*60000;
					var ending;
					var item;
					this.events.splice(0, 0, ({ startTime: new Date(), endTime: new Date() }));
					for (i = 0; i < this.events.length - 1; i++){
						var a = this.events[i];
						var b = this.events[i + 1];
						ending = new Date(a.endTime.getTime() + timeInMillSec);
						difference = (b.startTime.getTime() - a.endTime.getTime());
						if (difference >= timeInMillSec){
							item = {
								itemID: this.currentID + 1,
								startTime: a.endTime,
								endTime: ending,
								desc: desc,
								itemType: identity,
							}
							break;
						}
					}
					this.events.splice(0, 1);
					if (this.events.length == 0){
						var starting = new Date();
						ending = new Date(starting.getTime() + timeInMillSec);
						item = {
							itemID: this.currentID + 1,
							startTime: starting,
							endTime: ending,
							desc: desc,
							itemType: identity,
						}
					}
					if (item == undefined){
						ending = new Date(this.events[this.events.length - 1].endTime.getTime() + timeInMillSec);
						item = {
							itemID: this.currentID + 1,
							startTime: this.events[this.events.length - 1].endTime,
							endTime: ending,
							desc: desc,
							itemType: identity,
						}
					}
					this.currentID += 1;
					this.events.push(item);
					this.dueID = item.itemID;
				},
				printDate: function(){
					var day = this.currentDate.getDate();
					for (monthKey in this.months){
						var months = this.months[monthKey];
						if (months.month == this.currentDate.getMonth()){
							var month = months.name;
						}
					}
					for (weekKey in this.weekdays){
						var week = this.weekdays[weekKey];
						if (week.id == this.currentDate.getDay()){
							var weekday = week.name;
						}
					}
					var year = this.currentDate.getFullYear();
					this.dateText = weekday + ", " + month + " " + day + ", " + year;
				},
				goBack: function(){
					var newDate = new Date(this.currentDate.getTime() - 86400000);
					this.currentDate = newDate;
					this.listByDate();
					this.printDate();
				},
				goForward: function(){
					var newDate = new Date(this.currentDate.getTime() + 86400000);
					this.currentDate = newDate;
					this.listByDate();
					this.printDate();
				},
				listByDate: function(){
					this.todaysEvents = [];
					for (eventKey in this.eventsText){
						var event = this.eventsText[eventKey];
						if (event.date.getMonth() == this.currentDate.getMonth() && event.date.getDate() == this.currentDate.getDate() && event.date.getFullYear() == this.currentDate.getFullYear()){
							this.todaysEvents.push(event);
						} else {
							this.remove_item(event.itemId)
						}
					}
				},
				pushEvent: function(id, start, end, desc, type){
					var event = {eventID: id, startTime: start.getTime(), endTime: end.getTime(), description: desc, itemType: type};
					console.log(event);
					$.post("upload.php", event);
				},
				shuffleFlex: function(){
					this.events = this.events.filter((item) => { return item.itemType !== "f" });
					for (eventKey in this.flex){
						var event = this.flex[eventKey];
						this.sortFlex(event.hours, event.minutes, event.desc);
					}
				},
				remove_item: function(itemID){
					this.events = this.events.filter((item) => { return item.itemID !== itemID });
          			this.eventsText = this.eventsText.filter((item) => { return item.itemID !== itemID });
          			this.todaysEvents = this.todaysEvents.filter((item) => { return item.itemID !== itemID });
				},
				autoRemoveItem: function(){
					var list = [];
					var now = new Date();
					for (eventKey in this.events){
						var event = this.events[eventKey];
						if (event.endTime < now){
							list.push(event.itemID);
						}
					}
					for (listKey in list){
						var item = list[listKey];
						this.remove_item(item);
					}
				}
			}	
		});
	</script>
</html>