interface TaskItemProps {
    name: string;
    description?: string;
    status: string;
    subtasks?: { id: number; name: string }[]; // Optional array of subtasks
    onClick?: () => void;
    children?: React.ReactNode;
}

export default function TaskItem({ name, description, status, subtasks, onClick, children }: TaskItemProps) {
    return (
        <div className="mb-2 flex items-center justify-between rounded border p-3">
            <div onClick={onClick}>
                <h4>{name}</h4>
                <h5>{description}</h5>
                <span className={`badge badge-${status.toLowerCase()}`}>{status}</span>
                <p>Subtasks: {subtasks ? subtasks.length : 0}</p>
            </div>
            <div>{children}</div> {/* Allows actions like Edit/Delete buttons */}
        </div>
    );
}
// Usage example:
