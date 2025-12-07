import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Button } from "@/components/ui/button";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { useState } from "react";
import { Report } from "@/lib/api";

export function ReportForm({
  onSubmit,
  isLoading,
  report,
}: {
  onSubmit: (payload: {
    title: string;
    description: string;
    status?: string;
  }) => Promise<void>;
  isLoading: boolean;
  report?: Report;
}) {
  const [title, setTitle] = useState<string>(report?.title ?? "");
  const [status, setStatus] = useState<string>(report?.status ?? "open");
  const [description, setDescription] = useState<string>(
    report?.description ?? ""
  );

  const isEdit = Boolean(report);

  function handleSubmitForm(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    onSubmit({ title, description, status });
  }

  return (
    <form onSubmit={handleSubmitForm} className="space-y-3 max-w-lg">
      <div className="space-y-1">
        <Label htmlFor="title">Title</Label>
        <Input
          autoFocus
          id="title"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          required
        />
      </div>

      <div className="space-y-1">
        <Label htmlFor="description">Description</Label>
        <Textarea
          id="description"
          rows={4}
          value={description}
          onChange={(e) => setDescription(e.target.value)}
        />
      </div>
      {isEdit && (
        <div className="space-y-1">
          <Label>Status</Label>
          <Select value={status} onValueChange={(value) => setStatus(value)}>
            <SelectTrigger className="w-full">
              <SelectValue placeholder="Select a status" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="open">Open</SelectItem>
              <SelectItem value="in_review">In review</SelectItem>
              <SelectItem value="closed">Closed</SelectItem>
            </SelectContent>
          </Select>
        </div>
      )}
      <Button type="submit" disabled={isLoading}>
        {isLoading ? "Saving..." : "Save"}
      </Button>
    </form>
  );
}
