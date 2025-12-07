"use client";

import { useFeatureFlags } from "@/hooks/feature-flags";
import { useCreateReport } from "@/hooks/reports";
import { ReportForm } from "@/components/report-form";
import { toast } from "sonner";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import Link from "next/link";

export default function NewReportPage() {
  const router = useRouter();
  const { isActiveOnFlag, isPending: flagsLoading } = useFeatureFlags();

  const { mutateAsync: createReport, isPending } = useCreateReport();

  if (!flagsLoading && !isActiveOnFlag("enable_report_creation")) {
    return (
      <main>
        <p className="text-sm text-slate-600">
          Creating new reports is currently disabled.
        </p>
      </main>
    );
  }

  async function handleSubmit(payload: { title: string; description: string }) {
    await createReport(payload);
    router.push("/");
    toast.success("Report created successfully.");
  }

  return (
    <main className="space-y-4">
      <header className="flex justify-between items-center">
        <h1 className="text-xl font-semibold">New Report</h1>
        <Button variant="ghost" size="sm" asChild>
          <Link href="/">Back to list</Link>
        </Button>
      </header>

      <ReportForm onSubmit={handleSubmit} isLoading={isPending} />
    </main>
  );
}
