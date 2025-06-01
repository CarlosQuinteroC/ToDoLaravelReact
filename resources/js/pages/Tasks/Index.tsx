import TaskItem from '@/components/TaskItem';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Index',
        href: '/index',
    },
];

type User = {
    name: string;
};

type Subtask = {
    id: number;
    name: string;
};

type Task = {
    id: number;
    name: string;
    description: string;
    status: string;
    subtasks?: Subtask[];
};
type IndexProps = {
    user: User;
    tasks: Task[];
};

export default function Index({ user, tasks }: IndexProps) {
    const [selectedTask, setSelectedTask] = useState<Task | null>(null);
    const [viewMode, setViewMode] = useState<'list' | 'grid'>('list');
    // Dummy deleteTask function (replace with actual logic as needed)
    const deleteTask = (taskId: number) => {
        alert(`Delete task with ID: ${taskId}`);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            {/* Add buttons to switch between list and grid view */}
            <div className="mb-4 flex justify-end">
                <button
                    onClick={() => setViewMode('list')}
                    className={`mr-2 border px-4 py-2 ${viewMode === 'list' ? 'bg-blue-500 text-white' : ''}`}
                >
                    List
                </button>
                <button onClick={() => setViewMode('grid')} className={`border px-4 py-2 ${viewMode === 'grid' ? 'bg-blue-500 text-white' : ''}`}>
                    Grid
                </button>
            </div>
            <Head title="Index" />
            <h1>Hola {user.name}</h1>
            <div className={`${viewMode === 'grid' ? 'grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3' : 'flex flex-col gap-4'}`}>
                {/* List tasks here */}
                {tasks.length === 0 ? (
                    <p>No tasks available.</p>
                ) : (
                    <>
                        {tasks.map((task) => (
                            <div key={task.id} className="task-item">
                                <p>Task ID: {task.id}</p>
                                <TaskItem
                                    name={task.name}
                                    status={task.status}
                                    description={task.description}
                                    subtasks={task.subtasks}
                                    onClick={() => setSelectedTask(task)}
                                >
                                    <button onClick={() => deleteTask(task.id)}>Delete</button>
                                </TaskItem>

                                {task.subtasks && task.subtasks.length > 0 && (
                                    <div className="ml-4 border-l border-gray-300 pl-4">
                                        <h4 className="mt-2 text-sm font-semibold">Subtasks:</h4>
                                        {task.subtasks.map((subtask) => (
                                            <TaskItem
                                                key={subtask.id}
                                                name={subtask.name}
                                                status={task.status}
                                                onClick={() => deleteTask(subtask.id)}
                                            >
                                                <button onClick={() => deleteTask(subtask.id)}>Delete</button>
                                            </TaskItem>
                                        ))}
                                    </div>
                                )}
                            </div>
                        ))}
                    </>
                )}
            </div>
        </AppLayout>
    );
}
