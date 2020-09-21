
dashboard = {

    admin_init: function(){
  
		var income_vs_expense = echarts.init(document.getElementById('income_vs_expense_chart'));

		option = {
			xAxis: {
				type: 'category',
				boundaryGap: false,
				data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ['Income', 'Expense']
			},
			yAxis: {
				type: 'value'
			},
			series: [
			{
				name:'Income',
				data: yearly_income,
				type: 'line',
				color: '#81ecec',
				areaStyle: {}
			},
			{
				name:'Expense',
				data: yearly_expense,
				type: 'line',
				color: '#e84393',
				areaStyle: {}
			}
			]
		};

		income_vs_expense.setOption(option);
		
		
	},
	
	accountant_init: function(){
  
		var income_vs_expense = echarts.init(document.getElementById('income_vs_expense_chart'));

		option = {
			xAxis: {
				type: 'category',
				boundaryGap: false,
				data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ['Income', 'Expense']
			},
			yAxis: {
				type: 'value'
			},
			series: [
			{
				name:'Income',
				data: yearly_income,
				type: 'line',
				color: '#81ecec',
				areaStyle: {}
			},
			{
				name:'Expense',
				data: yearly_expense,
				type: 'line',
				color: '#e84393',
				areaStyle: {}
			}
			]
		};

		income_vs_expense.setOption(option);
		
		
	}
	
}
