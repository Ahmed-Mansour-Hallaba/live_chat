<template>
    <div>
        <li class="list-group-item" :class="className"><slot></slot>
        <span id="time">{{time}}</span></li>
        <small class="badge" :class="badgeClass">{{user}}</small>
    </div>
</template>

<script>
export default {
    props:[
        'color',
        'user',
        'time'
    ],
    computed:{
        className(){
            return 'list-group-item-'+this.color;
        },
        badgeClass(){
            if(this.color=='warning')
                return 'badge-'+this.color+' float-right';
            else
                 return 'badge-'+this.color+' float-left';

        }
    },
    mounted(){
        console.log('Component mounted');
    }
}
</script>

<style scoped>
    #time{
        font-size: 14px;
        margin-top: 10px;
        color:black;
    }
</style>
