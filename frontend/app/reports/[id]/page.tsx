"use client";

import { useParams, useRouter } from "next/navigation";
import { useFeatureFlags } from "@/hooks/feature-flags";
import { useReport, useUpdateReport } from "@/hooks/reports";
import { ReportForm } from "@/components/report-form";
import { Spinner } from "@/components/ui/spinner";
import { toast } from "sonner";
import { Button } from "@/components/ui/button";
import Link from "next/link";

export default function ReportDetailPage() {
  const params = useParams();
  const router = useRouter();
  const id = params?.id as string;

  const { report, isPending: reportLoading, error } = useReport(id);
  const { mutateAsync: updateReport, isPending: updateReportLoading } =
    useUpdateReport();
  const { isActiveOnFlag, isLoading: flagsLoading } = useFeatureFlags();

  const editingEnabled = isActiveOnFlag("enable_report_editing");

  async function handleSubmit(payload: { title: string; description: string }) {
    if (!report?.id) return;
    await updateReport({ id: report.id, ...payload });
    router.push("/");
    toast.success("Report updated successfully.");
  }

  if (reportLoading || flagsLoading)
    return <Spinner className="w-6 h-6 mr-2" />;

  if (!editingEnabled)
    return <p>Editing this report is disabled by a feature flag now.</p>;

  if (!report) return <p>Report not found.</p>;

  if (error) return <p>Error loading report.</p>;

  return (
    <main className="space-y-4 max-w-xl">
      <header className="flex justify-between items-center">
        <h1 className="text-xl font-semibold">Report detail</h1>
        <Button variant="ghost" size="sm" asChild>
          <Link href="/">Back to list</Link>
        </Button>
      </header>
      {report && (
        <ReportForm
          onSubmit={handleSubmit}
          isLoading={updateReportLoading}
          report={report}
        />
      )}
    </main>
  );
}
