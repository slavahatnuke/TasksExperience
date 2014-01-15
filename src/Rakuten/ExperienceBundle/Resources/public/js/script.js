// Here's my data model

$(function() {

    function Task(data) {
        this.title = ko.observable(data.title);
        this.isDone = ko.observable(data.isDone);
    }

    function TaskListViewModel() {
        // Data
        var self = this;
        self.tasks = ko.observableArray();
        self.all = ko.observable(false)

        $.getJSON("/tasks/1", function(data) {
            var newtask = new Task(ko.mapping.fromJS(data.tasks))
            self.tasks.push(newtask);
            var unmapped = ko.mapping.toJS(newtask);
        });

        self.incompleteTasks = ko.computed(function() {
            return ko.utils.arrayFilter(self.tasks(), function(task) {
                return !task.isDone()
            });
        });

        // Operations
        self.addTask = function() {
            self.tasks.push(new Task({ title: ""}));
        };

        self.deleteAll = function() {
            self.tasks.removeAll();
        }

        self.removeTask = function(task) { self.tasks.remove(task) };

        self.checkAll = function() {
            for (var i = 0; i < self.tasks().length; i++)
                self.tasks()[i].isDone(true);
        }
    }

    ko.applyBindings(new TaskListViewModel());

});