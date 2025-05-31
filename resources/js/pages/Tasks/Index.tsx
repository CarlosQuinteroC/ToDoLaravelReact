import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

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
    subtasks?: Subtask[];
};
type IndexProps = {
    user: User;
    tasks: Task[];
};
export default function Index({ user, tasks }: IndexProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Index" />
            <h1>Hola {user.name}</h1>
            {/* List tasks here */}
            {tasks.length === 0 ? (
                <p>No tasks available.</p>
            ) : (
                <>
                    {tasks.map((task) => (
                        <div key={task.id} className="task-item">
                            <h2>{task.name}</h2>
                            <p>{task.description}</p>
                            {task.subtasks && task.subtasks.length > 0 && (
                                <>
                                    <h3>Subtasks:</h3>
                                    <ul>
                                        {task.subtasks.map((subtask) => (
                                            <li key={subtask.id}>{subtask.name}</li>
                                        ))}
                                    </ul>
                                </>
                            )}
                            <p>Task ID: {task.id}</p>
                        </div>
                    ))}
                </>
            )}
        </AppLayout>
    );
}
