// Here's my data model

$(function() {

    function Task() {
        var self = this;
        this.id = ko.observable();
        this.title = ko.observable("");
        this.isDone = ko.observable(false);

        self.putTask = function() {
            $.ajax(Routing.generate('put_task', { id: self.id() }), {
                data: ko.toJSON(self),
                type: "put", contentType: "application/json"
            });
        };

        this.title.subscribe(function() {
            self.putTask();
        });

        this.isDone.subscribe(function() {
            self.putTask();
        });
    }

    function TaskListViewModel() {
        // Data
        var self = this;
        self.tasks = ko.observableArray();
        self.all = ko.observable(false);

        self.getTasks = function() {
            $.getJSON(Routing.generate('get_tasks'), function(data) {
                ko.mapping.fromJS(data, mapping, self.tasks);
            });
        };

        var mapping = {
            create: function(options) {
                var task = new Task();
                task.id(options.data.id);
                task.title(options.data.title);
                task.isDone(options.data.is_done);
                return  task;
            }
        };

        self.getTasks();

        self.incompleteTasks = ko.computed(function() {
            return ko.utils.arrayFilter(self.tasks(), function(task) {
                return !task.isDone()
            });
        });

        self.addTask = function() {
            var task = new Task();
            $.getJSON(Routing.generate('new_tasks'), function(data) {
                ko.mapping.fromJS(data, mapping, task);
                self.tasks.push(task);
            });

        };

        self.removeTask = function(task) {
            $.ajax(Routing.generate('delete_task', { id: task.id() }), {
                type: "delete",
                success: function() {
                    self.tasks.remove(task)
                }
            });
        };
    }

    ko.applyBindings(new TaskListViewModel());

});